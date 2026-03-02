<?php

namespace App\Http\Controllers;

use App\Neuron\ChatAssistant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use NeuronAI\Chat\Messages\AssistantMessage;
use NeuronAI\Chat\Messages\UserMessage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicChatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('PublicChat');
    }

    public function message(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'messages' => 'required|array',
            'messages.*.role' => 'required|in:user,assistant',
            'messages.*.content' => 'required|string|max:4000',
        ]);

        return response()->stream(function () use ($validated, $request) {
            try {
                $assistant = ChatAssistant::make();
                $assistant->setLocale($request->route('locale', 'en'));

                // Build messages array for the assistant
                $messages = [];
                foreach ($validated['messages'] as $msg) {
                    if ($msg['role'] === 'user') {
                        $messages[] = new UserMessage($msg['content']);
                    } elseif ($msg['role'] === 'assistant') {
                        $messages[] = new AssistantMessage($msg['content']);
                    }
                }

                // Stream the response
                foreach ($assistant->stream($messages) as $chunk) {
                    if (is_string($chunk)) {
                        echo "event: chunk\n";
                        echo 'data: ' . json_encode(['content' => $chunk]) . "\n\n";

                        if (ob_get_level() > 0) {
                            ob_flush();
                        }
                        flush();
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Chat stream failed', [
                    'message' => $e->getMessage(),
                    'locale'  => $request->route('locale'),
                ]);
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

}
