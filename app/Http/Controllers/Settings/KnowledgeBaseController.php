<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\UploadedFile;
use App\Neuron\ChatAssistant;
use App\Services\Parsers\ImageParser;
use App\Services\Parsers\PdfParser;
use App\Services\Parsers\TextParser;
use App\Services\Parsers\WordParser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class KnowledgeBaseController extends Controller
{
    private const DOCUMENT_TYPES = ['bio', 'skills', 'experience', 'project', 'education', 'general'];

    public function index(Request $request): Response
    {
        $documents = Document::latest()
            ->paginate(15)
            ->through(fn ($doc) => [
                'id' => $doc->id,
                'title' => $doc->title,
                'type' => $doc->type,
                'source' => $doc->source,
                'chunk_index' => $doc->chunk_index,
                'created_at' => $doc->created_at->toDateTimeString(),
            ]);

        $stats = Document::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return Inertia::render('settings/KnowledgeBase', [
            'documents' => $documents,
            'stats' => $stats,
            'documentTypes' => self::DOCUMENT_TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(self::DOCUMENT_TYPES)],
            'content' => ['required', 'string'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        $embedding = ChatAssistant::make()->getEmbeddingsProvider()->embedText($validated['content']);

        Document::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $validated['content'],
            'source' => $validated['source'] ?? null,
            'embedding' => $embedding,
            'chunk_index' => 0,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Document added successfully.');
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:20480', 'mimes:md,txt,pdf,doc,docx,jpg,jpeg,png,gif,webp,svg'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(self::DOCUMENT_TYPES)],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $request->file('file');
        $mimeType = $file->getMimeType();
        $originalName = $file->getClientOriginalName();
        $storedPath = $file->store('knowledge-base', 'local');

        $uploadedFile = UploadedFile::create([
            'user_id' => Auth::id(),
            'original_filename' => $originalName,
            'stored_filename' => basename($storedPath),
            'disk' => 'local',
            'path' => $storedPath,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'status' => 'processing',
        ]);

        try {
            $parser = $this->resolveParser($mimeType, $file->getClientOriginalExtension());

            if ($parser === null) {
                $uploadedFile->markAsFailed("Unsupported file type: {$mimeType}");

                return back()->withErrors(['file' => 'Unsupported file type.']);
            }

            $fullPath = Storage::disk('local')->path($storedPath);
            $content = $parser->parse($fullPath);

            if (empty(trim($content))) {
                $content = "(No text content could be extracted from this file.)";
            }

            $embedding = ChatAssistant::make()->getEmbeddingsProvider()->embedText($content);

            $document = Document::create([
                'title' => $request->input('title'),
                'type' => $request->input('type'),
                'content' => $content,
                'source' => $request->input('source'),
                'embedding' => $embedding,
                'chunk_index' => 0,
                'uploaded_file_id' => $uploadedFile->id,
                'user_id' => Auth::id(),
            ]);

            $uploadedFile->markAsCompleted(1);
        } catch (\Throwable $e) {
            $uploadedFile->markAsFailed($e->getMessage());

            return back()->withErrors(['file' => 'Failed to process file: ' . $e->getMessage()]);
        }

        return back()->with('success', 'File imported and embedded successfully.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $uploadedFile = $document->uploadedFile;

        $document->delete();

        // Clean up the uploaded file record if it has no remaining documents
        if ($uploadedFile && $uploadedFile->documents()->count() === 0) {
            $uploadedFile->deleteFile();
            $uploadedFile->delete();
        }

        return back()->with('success', 'Document deleted.');
    }

    private function resolveParser(string $mimeType, string $extension): ?object
    {
        $extension = strtolower($extension);

        return match (true) {
            in_array($extension, ['md', 'txt']) => new TextParser(),
            $extension === 'pdf' => new PdfParser(),
            in_array($extension, ['doc', 'docx']) => new WordParser(),
            in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) => new ImageParser(),
            (new TextParser())->supports($mimeType) => new TextParser(),
            (new PdfParser())->supports($mimeType) => new PdfParser(),
            (new WordParser())->supports($mimeType) => new WordParser(),
            (new ImageParser())->supports($mimeType) => new ImageParser(),
            default => null,
        };
    }
}
