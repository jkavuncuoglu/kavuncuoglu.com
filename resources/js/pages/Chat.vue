<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { ChatPageProps } from '@/types';
import ChatSidebar from '@/components/chat/ChatSidebar.vue';
import ChatContainer from '@/components/chat/ChatContainer.vue';
import { useChat } from '@/composables/useChat';
import GuestLayout from '@/layouts/GuestLayout.vue';

const props = defineProps<ChatPageProps>();

const {
    conversations,
    activeConversation,
    messages,
    isLoading,
    isStreaming,
    streamingContent,
    createConversation,
    selectConversation,
    sendMessage,
    deleteConversation,
} = useChat(props.conversations);

async function handleNewConversation() {
    try {
        await createConversation();
    } catch (e) {
        console.error('Failed to create conversation:', e);
    }
}

async function handleSelectConversation(conversation: typeof conversations.value[0]) {
    try {
        await selectConversation(conversation);
    } catch (e) {
        console.error('Failed to select conversation:', e);
    }
}

async function handleDeleteConversation(conversation: typeof conversations.value[0]) {
    try {
        await deleteConversation(conversation);
    } catch (e) {
        console.error('Failed to delete conversation:', e);
    }
}

async function handleSendMessage(content: string) {
    try {
        if (!activeConversation.value) {
            await createConversation();
        }
        await sendMessage(content);
    } catch (e) {
        console.error('Failed to send message:', e);
    }
}
</script>

<template>
    <Head title="Chat" />

    <GuestLayout>
        <div class="flex h-full overflow-hidden">
            <ChatSidebar
                :conversations="conversations"
                :active-conversation-id="activeConversation?.id"
                :is-loading="isLoading"
                @new-conversation="handleNewConversation"
                @select="handleSelectConversation"
                @delete="handleDeleteConversation"
            />
            <ChatContainer
                :messages="messages"
                :is-streaming="isStreaming"
                :streaming-content="streamingContent"
                :has-active-conversation="!!activeConversation"
                @send-message="handleSendMessage"
            />
        </div>
    </GuestLayout>
</template>
