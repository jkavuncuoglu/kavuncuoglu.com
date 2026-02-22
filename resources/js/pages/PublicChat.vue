<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { MessageSquare, Trash2 } from 'lucide-vue-next';
import ChatMessageList from '@/components/chat/ChatMessageList.vue';
import ChatInput from '@/components/chat/ChatInput.vue';
import { usePublicChat } from '@/composables/usePublicChat';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const {
    messages,
    isStreaming,
    streamingContent,
    error,
    sendMessage,
    clearChat,
} = usePublicChat();

async function handleSendMessage(content: string) {
    try {
        await sendMessage(content);
    } catch (e) {
        console.error('Failed to send message:', e);
    }
}

async function handleClearChat() {
    try {
        await clearChat();
    } catch (e) {
        console.error('Failed to clear chat:', e);
    }
}
</script>

<template>
    <Head :title="t('chat.page_title')" />

    <GuestLayout :full-height="true" :show-footer="false">
        <div class="flex h-full flex-col overflow-hidden">
            <!-- Toolbar -->
            <div v-if="messages.length > 0" class="flex justify-end px-4 py-2 border-b border-[#e3e3e0] dark:border-[#1f1f1f]">
                <Button
                    variant="outline"
                    size="sm"
                    @click="handleClearChat"
                >
                    <Trash2 class="mr-2 h-4 w-4" />
                    {{ t('chat.clear') }}
                </Button>
            </div>

            <div class="flex flex-1 flex-col overflow-hidden">
                <!-- Welcome message when no messages -->
                <div
                    v-if="messages.length === 0 && !isStreaming"
                    class="flex flex-1 items-center justify-center"
                >
                    <div class="text-muted-foreground text-center">
                        <MessageSquare class="mx-auto mb-4 h-12 w-12 opacity-50" />
                        <p class="text-lg font-medium">{{ t('chat.welcome_heading') }}</p>
                        <p class="text-sm">{{ t('chat.welcome_body') }}</p>
                    </div>
                </div>

                <!-- Messages -->
                <template v-else>
                    <ChatMessageList
                        :messages="messages"
                        :is-streaming="isStreaming"
                        :streaming-content="streamingContent"
                    />
                </template>

                <!-- Error message -->
                <div
                    v-if="error"
                    class="bg-destructive/10 text-destructive border-destructive/20 border-t px-4 py-2 text-sm"
                >
                    {{ error }}
                </div>

                <!-- Input -->
                <ChatInput
                    :disabled="isStreaming"
                    :placeholder="t('chat.placeholder')"
                    @submit="handleSendMessage"
                />
            </div>
        </div>
    </GuestLayout>
</template>
