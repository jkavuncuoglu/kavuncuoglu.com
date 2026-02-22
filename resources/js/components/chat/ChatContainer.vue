<script setup lang="ts">
import type { Message } from '@/types/chat';
import ChatMessageList from './ChatMessageList.vue';
import ChatInput from './ChatInput.vue';

type Props = {
    messages: Message[];
    isStreaming?: boolean;
    streamingContent?: string;
    hasActiveConversation?: boolean;
};

withDefaults(defineProps<Props>(), {
    isStreaming: false,
    streamingContent: '',
    hasActiveConversation: false,
});

const emit = defineEmits<{
    (e: 'send-message', content: string): void;
}>();
</script>

<template>
    <div class="flex h-full flex-1 flex-col">
        <div v-if="!hasActiveConversation" class="flex h-full items-center justify-center">
            <div class="text-muted-foreground text-center">
                <p class="text-lg font-medium">Welcome to the Chat</p>
                <p class="text-sm">
                    Select a conversation from the sidebar or start a new one.
                </p>
            </div>
        </div>
        <template v-else>
            <ChatMessageList
                :messages="messages"
                :is-streaming="isStreaming"
                :streaming-content="streamingContent"
            />
            <ChatInput
                :disabled="isStreaming"
                @submit="emit('send-message', $event)"
            />
        </template>
    </div>
</template>
