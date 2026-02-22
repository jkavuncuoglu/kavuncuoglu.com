<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Neuron\ChatAssistant;

class ChatService
{
    public function createConversation(User $user, ?string $title = null): Conversation
    {
        return Conversation::create([
            'user_id' => $user->id,
            'title' => $title ?? 'New Conversation',
        ]);
    }

    public function sendMessage(Conversation $conversation, string $content): Message
    {
        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $content,
        ]);

        if ($conversation->title === 'New Conversation' || $conversation->title === null) {
            $conversation->update([
                'title' => $this->generateTitle($content),
            ]);
        }

        $conversationHistory = $this->getConversationHistory($conversation, $userMessage->id);

        $assistant = ChatAssistant::make();
        $response = $assistant->answerQuestion($content, $conversationHistory);

        $assistantMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $response,
        ]);

        $conversation->touch();

        return $assistantMessage;
    }

    public function streamMessage(Conversation $conversation, string $content): \Generator
    {
        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $content,
        ]);

        if ($conversation->title === 'New Conversation' || $conversation->title === null) {
            $conversation->update([
                'title' => $this->generateTitle($content),
            ]);
        }

        $conversationHistory = $this->getConversationHistory($conversation, $userMessage->id);

        $assistant = ChatAssistant::make();

        $fullResponse = '';

        foreach ($assistant->streamAnswer($content, $conversationHistory) as $chunk) {
            if (is_string($chunk)) {
                $fullResponse .= $chunk;
                yield $chunk;
            }
        }

        $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $fullResponse,
        ]);

        $conversation->touch();
    }

    protected function getConversationHistory(Conversation $conversation, int $excludeMessageId): array
    {
        return $conversation->messages()
            ->where('id', '<', $excludeMessageId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn(Message $msg) => [
                'role' => $msg->role,
                'content' => $msg->content,
            ])
            ->toArray();
    }

    protected function generateTitle(string $content): string
    {
        $title = substr($content, 0, 50);
        if (strlen($content) > 50) {
            $title .= '...';
        }
        return $title;
    }
}
