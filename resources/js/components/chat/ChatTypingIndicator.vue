<script setup lang="ts">
import { Bot } from 'lucide-vue-next';

type Props = {
    content?: string;
};

defineProps<Props>();
</script>

<template>
    <div class="flex gap-3 p-4">
        <div
            class="bg-muted text-muted-foreground flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
        >
            <Bot class="h-4 w-4" />
        </div>
        <div class="bg-muted text-foreground max-w-[80%] rounded-lg px-4 py-2">
            <div v-if="content" class="prose prose-sm dark:prose-invert max-w-none">
                <p class="whitespace-pre-wrap">
                    {{ content }}<span
                        class="ml-1 inline-block h-4 w-1 animate-pulse bg-current"
                    ></span>
                </p>
            </div>
            <div v-else class="flex items-center gap-1">
                <span class="bg-foreground/50 h-2 w-2 animate-bounce rounded-full [animation-delay:-0.3s]"></span>
                <span class="bg-foreground/50 h-2 w-2 animate-bounce rounded-full [animation-delay:-0.15s]"></span>
                <span class="bg-foreground/50 h-2 w-2 animate-bounce rounded-full"></span>
            </div>
        </div>
    </div>
</template>
