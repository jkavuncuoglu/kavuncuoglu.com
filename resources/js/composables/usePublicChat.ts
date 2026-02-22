import { usePage } from '@inertiajs/vue3';
import { ref, watch, computed, type Ref } from 'vue';

export type Message = {
    role: 'user' | 'assistant';
    content: string;
};

export type UsePublicChatReturn = {
    messages: Ref<Message[]>;
    isStreaming: Ref<boolean>;
    streamingContent: Ref<string>;
    error: Ref<string | null>;
    sendMessage: (content: string) => Promise<void>;
    clearChat: () => Promise<void>;
};

const CHAT_STORAGE_KEY = 'public_chat_history';

export function usePublicChat(): UsePublicChatReturn {
    const messages = ref<Message[]>([]);
    const isStreaming = ref(false);
    const streamingContent = ref('');
    const error = ref<string | null>(null);

    const locale = computed(() => (usePage().props.locale as string) || 'en');
    const messageUrl = computed(() => `/${locale.value}/chat/message`);

    // Load messages from localStorage on init
    try {
        const storedMessages = localStorage.getItem(CHAT_STORAGE_KEY);
        if (storedMessages) {
            messages.value = JSON.parse(storedMessages);
        }
    } catch (e) {
        console.error('Failed to load messages from localStorage', e);
        localStorage.removeItem(CHAT_STORAGE_KEY);
    }

    // Watch for changes in messages and save to localStorage
    watch(
        messages,
        (newMessages) => {
            try {
                localStorage.setItem(CHAT_STORAGE_KEY, JSON.stringify(newMessages));
            } catch (e) {
                console.error('Failed to save messages to localStorage', e);
            }
        },
        { deep: true },
    );

    async function sendMessage(content: string): Promise<void> {
        if (isStreaming.value) {
            return;
        }

        isStreaming.value = true;
        streamingContent.value = '';
        error.value = null;

        const currentHistory = [...messages.value];
        const newMessage: Message = { role: 'user', content };
        messages.value.push(newMessage);

        try {
            const response = await fetch(messageUrl.value, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'text/event-stream',
                    'X-CSRF-TOKEN':
                        document.querySelector<HTMLMetaElement>(
                            'meta[name="csrf-token"]',
                        )?.content ?? '',
                },
                body: JSON.stringify({
                    messages: [...currentHistory, newMessage],
                }),
            });

            if (!response.ok) {
                throw new Error('Failed to send message');
            }

            const reader = response.body?.getReader();
            const decoder = new TextDecoder();

            if (!reader) {
                throw new Error('No response body');
            }

            let buffer = '';
            let assistantMessage = '';

            while (true) {
                const { done, value } = await reader.read();

                if (done) {
                    break;
                }

                buffer += decoder.decode(value, { stream: true });

                const lines = buffer.split('\n');
                buffer = lines.pop() ?? '';

                let eventType = '';

                for (const line of lines) {
                    if (line.startsWith('event: ')) {
                        eventType = line.slice(7);
                    } else if (line.startsWith('data: ')) {
                        const data = JSON.parse(line.slice(6));
                        handleSSEEvent(eventType, data, (chunk) => {
                            assistantMessage += chunk;
                        });
                    }
                }
            }

            if (assistantMessage) {
                messages.value.push({ role: 'assistant', content: assistantMessage });
            }

        } catch (e) {
            error.value =
                e instanceof Error ? e.message : 'An error occurred';
            // On error, remove the user message that was added optimistically
            messages.value.pop();
        } finally {
            isStreaming.value = false;
            streamingContent.value = '';
        }
    }

    function handleSSEEvent(eventType: string, data: unknown, callback: (chunk: string) => void): void {
        switch (eventType) {
            case 'chunk': {
                const chunk = data as { content: string };
                streamingContent.value += chunk.content;
                callback(chunk.content);
                break;
            }
            case 'error': {
                const errorData = data as { error: string };
                error.value = errorData.error;
                break;
            }
        }
    }

    async function clearChat(): Promise<void> {
        messages.value = [];
        error.value = null;
        localStorage.removeItem(CHAT_STORAGE_KEY);
    }

    return {
        messages,
        isStreaming,
        streamingContent,
        error,
        sendMessage,
        clearChat,
    };
}
