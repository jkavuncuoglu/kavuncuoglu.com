<script setup lang="ts">
import { ref, watch, nextTick } from 'vue';
import { useI18n } from 'vue-i18n';
import type { Message } from '@/types/chat';
import ChatMessage from './ChatMessage.vue';
import ChatTypingIndicator from './ChatTypingIndicator.vue';

const { t } = useI18n();

type Props = {
    messages: Message[];
    isStreaming?: boolean;
    streamingContent?: string;
};

const props = withDefaults(defineProps<Props>(), {
    isStreaming: false,
    streamingContent: '',
});

const scrollContainer = ref<HTMLDivElement | null>(null);

function scrollToBottom() {
    nextTick(() => {
        if (scrollContainer.value) {
            scrollContainer.value.scrollTop = scrollContainer.value.scrollHeight;
        }
    });
}

watch(
    () => [props.messages.length, props.streamingContent],
    () => {
        scrollToBottom();
    },
);
</script>

<template>
    <div ref="scrollContainer" class="flex-1 overflow-y-auto">
        <div v-if="messages.length === 0" class="flex h-full items-center justify-center">
            <div class="text-muted-foreground text-center">
                <p class="text-lg font-medium">{{ t('chat.empty_heading') }}</p>
                <p class="text-sm">{{ t('chat.empty_body') }}</p>
            </div>
        </div>
        <div v-else class="space-y-2 py-4">
            <ChatMessage
                v-for="message in messages"
                :key="message.id"
                :message="message"
            />
            <ChatTypingIndicator
                v-if="isStreaming"
                :content="streamingContent"
            />
        </div>
    </div>
</template>
