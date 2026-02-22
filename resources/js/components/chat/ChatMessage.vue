<script setup lang="ts">
import type { Message } from '@/types/chat';
import { cn } from '@/lib/utils';
import { User, Bot } from 'lucide-vue-next';

type Props = {
    message: Message;
    isStreaming?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
    isStreaming: false,
});
</script>

<template>
    <div
        :class="
            cn(
                'flex gap-3 p-4',
                message.role === 'user' ? 'flex-row-reverse' : 'flex-row',
            )
        "
    >
        <div
            :class="
                cn(
                    'flex h-8 w-8 shrink-0 items-center justify-center rounded-full',
                    message.role === 'user'
                        ? 'bg-primary text-primary-foreground'
                        : 'bg-muted text-muted-foreground',
                )
            "
        >
            <User v-if="message.role === 'user'" class="h-4 w-4" />
            <Bot v-else class="h-4 w-4" />
        </div>
        <div
            :class="
                cn(
                    'max-w-[80%] rounded-lg px-4 py-2',
                    message.role === 'user'
                        ? 'bg-primary text-primary-foreground'
                        : 'bg-muted text-foreground',
                )
            "
        >
            <div class="prose prose-sm dark:prose-invert max-w-none">
                <p class="whitespace-pre-wrap">{{ message.content }}</p>
            </div>
            <span
                v-if="isStreaming"
                class="ml-1 inline-block h-4 w-1 animate-pulse bg-current"
            ></span>
        </div>
    </div>
</template>
