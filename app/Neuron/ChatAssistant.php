<?php

namespace App\Neuron;

use App\Models\Document;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Ollama\Ollama;
use NeuronAI\RAG\Embeddings\EmbeddingsProviderInterface;
use NeuronAI\RAG\RAG;
use NeuronAI\RAG\VectorStore\VectorStoreInterface;
use NeuronAI\SystemPrompt;

class ChatAssistant extends RAG
{
    protected function provider(): AIProviderInterface
    {
        return new Ollama(
            url: config('services.ollama.url', 'http://ollama:11434') . '/api',
            model: config('services.ollama.model', 'llama3.2'),
            parameters: [
                'options' => [
                    'num_ctx' => config('services.ollama.num_ctx', 4096),
                    'num_predict' => config('services.ollama.num_predict', 512),
                    'temperature' => config('services.ollama.temperature', 0.7),
                    'top_p' => 0.9,
                    'repeat_penalty' => 1.1,
                ],
            ],
        );
    }

    protected function embeddings(): EmbeddingsProviderInterface
    {
        return new OllamaEmbeddings(
            model: config('services.ollama.embedding_model', 'nomic-embed-text'),
            url: config('services.ollama.url', 'http://ollama:11434'),
        );
    }

    protected function vectorStore(): VectorStoreInterface
    {
        return new DatabaseVectorStore();
    }

    public function instructions(): string
    {
        return (string) new SystemPrompt(
            background: [
                'You are a helpful AI assistant for Jeremy Kavuncuoglu\'s personal website.',
                'You help visitors learn about Jeremy\'s work experience, skills, and projects.',
                'You are friendly, professional, and concise in your responses.',
                'When you don\'t know something specific about Jeremy, be honest about it.',
            ],
            steps: [
                'Analyze the user\'s question to understand what they want to know.',
                'Use the provided context to give accurate information about Jeremy.',
                'If the context doesn\'t contain relevant information, acknowledge this politely.',
                'Keep responses conversational and engaging.',
            ],
            output: [
                'Provide clear, well-structured responses.',
                'Use markdown formatting when helpful (lists, bold, etc.).',
                'Keep responses concise but informative.',
            ]
        );
    }

    public function answerQuestion(string $question, array $conversationHistory = []): string
    {
        $messages = [];

        foreach ($conversationHistory as $msg) {
            if ($msg['role'] === 'user') {
                $messages[] = new UserMessage($msg['content']);
            } elseif ($msg['role'] === 'assistant') {
                $messages[] = new \NeuronAI\Chat\Messages\AssistantMessage($msg['content']);
            }
        }

        $messages[] = new UserMessage($question);

        $response = $this->chat($messages);

        return $response->getContent();
    }

    public function streamAnswer(string $question, array $conversationHistory = []): \Generator
    {
        $messages = [];

        foreach ($conversationHistory as $msg) {
            if ($msg['role'] === 'user') {
                $messages[] = new UserMessage($msg['content']);
            } elseif ($msg['role'] === 'assistant') {
                $messages[] = new \NeuronAI\Chat\Messages\AssistantMessage($msg['content']);
            }
        }

        $messages[] = new UserMessage($question);

        return $this->stream($messages);
    }

    public function getEmbeddingsProvider(): EmbeddingsProviderInterface
    {
        return $this->embeddings();
    }
}
