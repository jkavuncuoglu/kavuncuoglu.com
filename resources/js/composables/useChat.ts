import { ref, computed, type Ref, type ComputedRef } from 'vue';
import type {
    Conversation,
    Message,
    ChunkEvent,
    CompleteEvent,
    ErrorEvent,
    TitleUpdatedEvent,
    UserMessageEvent,
} from '@/types/chat';

export type UseChatReturn = {
    conversations: Ref<Conversation[]>;
    activeConversation: Ref<Conversation | null>;
    messages: ComputedRef<Message[]>;
    isLoading: Ref<boolean>;
    isStreaming: Ref<boolean>;
    streamingContent: Ref<string>;
    error: Ref<string | null>;
    createConversation: () => Promise<Conversation>;
    selectConversation: (conversation: Conversation) => Promise<void>;
    sendMessage: (content: string) => Promise<void>;
    deleteConversation: (conversation: Conversation) => Promise<void>;
};

export function useChat(initialConversations: Conversation[] = []): UseChatReturn {
    const conversations = ref<Conversation[]>(initialConversations);
    const activeConversation = ref<Conversation | null>(null);
    const isLoading = ref(false);
    const isStreaming = ref(false);
    const streamingContent = ref('');
    const error = ref<string | null>(null);

    const messages = computed<Message[]>(() => {
        return activeConversation.value?.messages ?? [];
    });

    async function createConversation(): Promise<Conversation> {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await fetch('/chat/conversations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector<HTMLMetaElement>(
                            'meta[name="csrf-token"]',
                        )?.content ?? '',
                },
            });

            if (!response.ok) {
                throw new Error('Failed to create conversation');
            }

            const data = await response.json();
            const newConversation: Conversation = {
                ...data.conversation,
                messages: [],
            };

            conversations.value = [newConversation, ...conversations.value];
            activeConversation.value = newConversation;

            return newConversation;
        } catch (e) {
            error.value =
                e instanceof Error ? e.message : 'An error occurred';
            throw e;
        } finally {
            isLoading.value = false;
        }
    }

    async function selectConversation(conversation: Conversation): Promise<void> {
        if (activeConversation.value?.id === conversation.id) {
            return;
        }

        isLoading.value = true;
        error.value = null;

        try {
            const response = await fetch(
                `/chat/conversations/${conversation.id}`,
                {
                    headers: {
                        Accept: 'application/json',
                    },
                },
            );

            if (!response.ok) {
                throw new Error('Failed to load conversation');
            }

            const data = await response.json();
            activeConversation.value = {
                ...data.conversation,
                messages: data.conversation.messages ?? [],
            };
        } catch (e) {
            error.value =
                e instanceof Error ? e.message : 'An error occurred';
            throw e;
        } finally {
            isLoading.value = false;
        }
    }

    async function sendMessage(content: string): Promise<void> {
        if (!activeConversation.value || isStreaming.value) {
            return;
        }

        isStreaming.value = true;
        streamingContent.value = '';
        error.value = null;

        try {
            const response = await fetch(
                `/chat/conversations/${activeConversation.value.id}/message`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'text/event-stream',
                        'X-CSRF-TOKEN':
                            document.querySelector<HTMLMetaElement>(
                                'meta[name="csrf-token"]',
                            )?.content ?? '',
                    },
                    body: JSON.stringify({ content }),
                },
            );

            if (!response.ok) {
                throw new Error('Failed to send message');
            }

            const reader = response.body?.getReader();
            const decoder = new TextDecoder();

            if (!reader) {
                throw new Error('No response body');
            }

            let buffer = '';

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
                        handleSSEEvent(eventType, data);
                    }
                }
            }
        } catch (e) {
            error.value =
                e instanceof Error ? e.message : 'An error occurred';
        } finally {
            isStreaming.value = false;
            streamingContent.value = '';
        }
    }

    function handleSSEEvent(eventType: string, data: unknown): void {
        if (!activeConversation.value) return;

        switch (eventType) {
            case 'user_message': {
                const userMsg = data as UserMessageEvent;
                if (!activeConversation.value.messages) {
                    activeConversation.value.messages = [];
                }
                activeConversation.value.messages.push({
                    id: userMsg.id,
                    conversation_id: activeConversation.value.id,
                    role: 'user',
                    content: userMsg.content,
                    created_at: userMsg.created_at,
                });
                break;
            }
            case 'chunk': {
                const chunk = data as ChunkEvent;
                streamingContent.value += chunk.content;
                break;
            }
            case 'complete': {
                const complete = data as CompleteEvent;
                if (!activeConversation.value.messages) {
                    activeConversation.value.messages = [];
                }
                activeConversation.value.messages.push({
                    id: complete.id,
                    conversation_id: activeConversation.value.id,
                    role: 'assistant',
                    content: complete.content,
                    created_at: complete.created_at,
                });
                break;
            }
            case 'title_updated': {
                const titleUpdate = data as TitleUpdatedEvent;
                activeConversation.value.title = titleUpdate.title;
                const idx = conversations.value.findIndex(
                    (c) => c.id === activeConversation.value?.id,
                );
                if (idx !== -1) {
                    conversations.value[idx].title = titleUpdate.title;
                }
                break;
            }
            case 'error': {
                const errorData = data as ErrorEvent;
                error.value = errorData.error;
                break;
            }
        }
    }

    async function deleteConversation(conversation: Conversation): Promise<void> {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await fetch(
                `/chat/conversations/${conversation.id}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector<HTMLMetaElement>(
                                'meta[name="csrf-token"]',
                            )?.content ?? '',
                    },
                },
            );

            if (!response.ok) {
                throw new Error('Failed to delete conversation');
            }

            conversations.value = conversations.value.filter(
                (c) => c.id !== conversation.id,
            );

            if (activeConversation.value?.id === conversation.id) {
                activeConversation.value = null;
            }
        } catch (e) {
            error.value =
                e instanceof Error ? e.message : 'An error occurred';
            throw e;
        } finally {
            isLoading.value = false;
        }
    }

    return {
        conversations,
        activeConversation,
        messages,
        isLoading,
        isStreaming,
        streamingContent,
        error,
        createConversation,
        selectConversation,
        sendMessage,
        deleteConversation,
    };
}
