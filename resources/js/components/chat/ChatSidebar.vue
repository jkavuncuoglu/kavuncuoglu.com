<script setup lang="ts">
import type { Conversation } from '@/types/chat';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { Plus, MessageSquare, Trash2 } from 'lucide-vue-next';

type Props = {
    conversations: Conversation[];
    activeConversationId?: number | null;
    isLoading?: boolean;
};

withDefaults(defineProps<Props>(), {
    activeConversationId: null,
    isLoading: false,
});

const emit = defineEmits<{
    (e: 'new-conversation'): void;
    (e: 'select', conversation: Conversation): void;
    (e: 'delete', conversation: Conversation): void;
}>();

function formatDate(dateString: string): string {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now.getTime() - date.getTime();
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

    if (diffDays === 0) {
        return 'Today';
    } else if (diffDays === 1) {
        return 'Yesterday';
    } else if (diffDays < 7) {
        return `${diffDays} days ago`;
    } else {
        return date.toLocaleDateString();
    }
}
</script>

<template>
    <div class="bg-sidebar flex h-full w-64 flex-col border-r">
        <div class="p-4">
            <Button
                @click="emit('new-conversation')"
                :disabled="isLoading"
                class="w-full"
                variant="outline"
            >
                <Plus class="mr-2 h-4 w-4" />
                New Chat
            </Button>
        </div>
        <div class="flex-1 overflow-y-auto px-2">
            <div v-if="conversations.length === 0" class="text-muted-foreground p-4 text-center text-sm">
                No conversations yet
            </div>
            <div v-else class="space-y-1">
                <div
                    v-for="conversation in conversations"
                    :key="conversation.id"
                    :class="
                        cn(
                            'group flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 text-sm transition-colors',
                            activeConversationId === conversation.id
                                ? 'bg-accent text-accent-foreground'
                                : 'hover:bg-accent/50',
                        )
                    "
                    @click="emit('select', conversation)"
                >
                    <MessageSquare class="text-muted-foreground h-4 w-4 shrink-0" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-medium">{{ conversation.title }}</p>
                        <p class="text-muted-foreground text-xs">
                            {{ formatDate(conversation.updated_at) }}
                        </p>
                    </div>
                    <Button
                        variant="ghost"
                        size="icon"
                        class="h-6 w-6 opacity-0 group-hover:opacity-100"
                        @click.stop="emit('delete', conversation)"
                    >
                        <Trash2 class="h-3 w-3" />
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
