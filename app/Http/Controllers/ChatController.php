<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $chatService
    ) {}

    public function index(Request $request): Response
    {
        $conversations = $request->user()
            ->conversations()
            ->select(['id', 'title', 'updated_at'])
            ->get();

        return Inertia::render('Chat', [
            'conversations' => $conversations,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $conversation = $this->chatService->createConversation(
            $request->user(),
            $request->input('title')
        );

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'title' => $conversation->title,
                'updated_at' => $conversation->updated_at,
            ],
        ], 201);
    }

    public function show(Request $request, Conversation $conversation): JsonResponse
    {
        Gate::authorize('view', $conversation);

        $conversation->load('messages:id,conversation_id,role,content,created_at');

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'title' => $conversation->title,
                'messages' => $conversation->messages,
            ],
        ]);
    }

    public function message(Request $request, Conversation $conversation): StreamedResponse
    {
        Gate::authorize('message', $conversation);

        $validated = $request->validate([
            'content' => 'required|string|max:4000',
        ]);

        return response()->stream(function () use ($conversation, $validated) {
            $userMessage = $conversation->messages()->create([
                'role' => 'user',
                'content' => $validated['content'],
            ]);

            echo "event: user_message\n";
            echo 'data: ' . json_encode([
                'id' => $userMessage->id,
                'role' => 'user',
                'content' => $userMessage->content,
                'created_at' => $userMessage->created_at,
            ]) . "\n\n";

            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();

            if ($conversation->title === 'New Conversation' || $conversation->title === null) {
                $title = substr($validated['content'], 0, 50);
                if (strlen($validated['content']) > 50) {
                    $title .= '...';
                }
                $conversation->update(['title' => $title]);

                echo "event: title_updated\n";
                echo 'data: ' . json_encode(['title' => $title]) . "\n\n";

                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            }

            $conversationHistory = $conversation->messages()
                ->where('id', '<', $userMessage->id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(fn($msg) => [
                    'role' => $msg->role,
                    'content' => $msg->content,
                ])
                ->toArray();

            try {
                $assistant = \App\Neuron\ChatAssistant::make();
                $fullResponse = '';

                foreach ($assistant->streamAnswer($validated['content'], $conversationHistory) as $chunk) {
                    if (is_string($chunk)) {
                        $fullResponse .= $chunk;

                        echo "event: chunk\n";
                        echo 'data: ' . json_encode(['content' => $chunk]) . "\n\n";

                        if (ob_get_level() > 0) {
                            ob_flush();
                        }
                        flush();
                    }
                }

                $assistantMessage = $conversation->messages()->create([
                    'role' => 'assistant',
                    'content' => $fullResponse,
                ]);

                echo "event: complete\n";
                echo 'data: ' . json_encode([
                    'id' => $assistantMessage->id,
                    'role' => 'assistant',
                    'content' => $fullResponse,
                    'created_at' => $assistantMessage->created_at,
                ]) . "\n\n";

                $conversation->touch();
            } catch (\Exception $e) {
                echo "event: error\n";
                echo 'data: ' . json_encode(['error' => 'Failed to generate response. Please try again.']) . "\n\n";
            }

            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function destroy(Request $request, Conversation $conversation): JsonResponse
    {
        Gate::authorize('delete', $conversation);

        $conversation->delete();

        return response()->json(['success' => true]);
    }
}
