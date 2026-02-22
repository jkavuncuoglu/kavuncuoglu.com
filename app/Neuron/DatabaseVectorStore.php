<?php

namespace App\Neuron;

use App\Models\Document;
use NeuronAI\RAG\Document as RAGDocument;
use NeuronAI\RAG\VectorStore\VectorStoreInterface;

class DatabaseVectorStore implements VectorStoreInterface
{
    protected int $topK;

    public function __construct(int $topK = 3)
    {
        $this->topK = $topK;
    }

    public function addDocument(RAGDocument $document): VectorStoreInterface
    {
        Document::create([
            'title' => $document->metadata['title'] ?? 'Untitled',
            'type' => $document->sourceType ?? 'general',
            'content' => $document->content,
            'embedding' => $document->embedding,
            'chunk_index' => $document->metadata['chunk_index'] ?? 0,
            'source' => $document->sourceName ?? null,
        ]);

        return $this;
    }

    public function addDocuments(array $documents): VectorStoreInterface
    {
        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    public function similaritySearch(array $embedding, ?int $topK = null, array $additionalArguments = []): array
    {
        $topK = $topK ?? $this->topK;

        $documents = Document::withEmbeddings()->get();

        $results = [];

        foreach ($documents as $doc) {
            $similarity = $this->cosineSimilarity($embedding, $doc->embedding);

            $ragDoc = new RAGDocument($doc->content);
            $ragDoc->id = $doc->id;
            $ragDoc->embedding = $doc->embedding;
            $ragDoc->sourceType = $doc->type;
            $ragDoc->sourceName = $doc->source ?? 'database';
            $ragDoc->score = $similarity;
            $ragDoc->metadata = [
                'id' => $doc->id,
                'title' => $doc->title,
                'type' => $doc->type,
                'chunk_index' => $doc->chunk_index,
            ];

            $results[] = [
                'document' => $ragDoc,
                'similarity' => $similarity,
            ];
        }

        usort($results, fn($a, $b) => $b['similarity'] <=> $a['similarity']);

        $topResults = array_slice($results, 0, $topK);

        return array_map(fn($r) => $r['document'], $topResults);
    }

    public function deleteBySource(string $sourceType, string $sourceName): VectorStoreInterface
    {
        Document::where('type', $sourceType)
            ->where('source', $sourceName)
            ->delete();

        return $this;
    }

    protected function cosineSimilarity(array $a, array $b): float
    {
        if (count($a) !== count($b) || count($a) === 0) {
            return 0.0;
        }

        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        for ($i = 0; $i < count($a); $i++) {
            $dotProduct += $a[$i] * $b[$i];
            $normA += $a[$i] * $a[$i];
            $normB += $b[$i] * $b[$i];
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        if ($normA === 0.0 || $normB === 0.0) {
            return 0.0;
        }

        return $dotProduct / ($normA * $normB);
    }
}
