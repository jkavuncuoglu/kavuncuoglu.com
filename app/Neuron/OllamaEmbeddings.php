<?php

namespace App\Neuron;

use GuzzleHttp\Client;
use NeuronAI\RAG\Embeddings\AbstractEmbeddingsProvider;

class OllamaEmbeddings extends AbstractEmbeddingsProvider
{
    protected Client $client;

    public function __construct(
        protected string $model,
        protected string $url = 'http://ollama:11434',
    ) {
        $this->client = new Client([
            'base_uri' => rtrim($url, '/') . '/',
            'timeout' => config('services.ollama.timeout', 120),
        ]);
    }

    public function embedText(string $text): array
    {
        $response = $this->client->post('api/embed', [
            'json' => [
                'model' => $this->model,
                'input' => $text,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['embeddings'][0] ?? [];
    }
}
