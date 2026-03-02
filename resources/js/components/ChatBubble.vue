<script setup lang="ts">
import { ref, nextTick, watch, computed } from 'vue';
import { MessageSquare, X, SendHorizontal, Bot, User, Trash2 } from 'lucide-vue-next';
import { usePublicChat } from '@/composables/usePublicChat';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const isOpen = ref(false);
const inputText = ref('');
const messagesContainer = ref<HTMLDivElement | null>(null);

const { messages, isStreaming, streamingContent, error, sendMessage, clearChat } = usePublicChat();

const examplePrompts = computed(() => [
    t('chat.bubble_prompt_1'),
    t('chat.bubble_prompt_2'),
    t('chat.bubble_prompt_3'),
    t('chat.bubble_prompt_4'),
]);

function toggleOpen() {
    isOpen.value = !isOpen.value;
}

async function handleSend(text?: string) {
    const content = (text ?? inputText.value).trim();
    if (!content || isStreaming.value) return;
    inputText.value = '';
    await sendMessage(content);
}

function handleKeydown(e: KeyboardEvent) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleSend();
    }
}

function scrollToBottom() {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
        }
    });
}

watch([() => messages.value.length, () => streamingContent.value], scrollToBottom);
</script>

<template>
    <div class="fixed bottom-6 right-6 z-[60] flex flex-col items-end gap-3">

        <!-- ── Slide-up panel ────────────────────────────────── -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            leave-active-class="transition duration-150 ease-in"
            enter-from-class="opacity-0 translate-y-4 scale-95"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-4 scale-95"
        >
            <div
                v-if="isOpen"
                class="flex w-[22rem] flex-col overflow-hidden rounded-2xl border border-[#e3e3e0] bg-[#FDFDFC] shadow-2xl dark:border-[#2a2a28] dark:bg-[#161615]"
                style="max-height: min(520px, calc(100dvh - 6rem));"
            >
                <!-- Panel header -->
                <div class="flex items-center justify-between border-b border-[#e3e3e0] px-4 py-3 dark:border-[#2a2a28]">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#1b1b18] dark:bg-[#EDEDEC]">
                            <Bot class="h-4 w-4 text-white dark:text-[#1b1b18]" />
                        </div>
                        <div>
                            <p class="text-sm font-semibold leading-tight">Jeremy's AI</p>
                            <p class="text-[10px] leading-tight text-[#706f6c] dark:text-[#A1A09A]">
                                <span class="mr-1 inline-block h-1.5 w-1.5 rounded-full bg-emerald-500 align-middle"></span>
                                Online · Powered by Ollama
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button
                            v-if="messages.length > 0"
                            @click="clearChat"
                            class="flex h-7 w-7 items-center justify-center rounded-md text-[#706f6c] transition-colors hover:bg-[#f4f4f2] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:bg-[#1f1f1f] dark:hover:text-[#EDEDEC]"
                            :title="t('chat.bubble_clear_title')"
                        >
                            <Trash2 class="h-3.5 w-3.5" />
                        </button>
                        <button
                            @click="toggleOpen"
                            class="flex h-7 w-7 items-center justify-center rounded-md text-[#706f6c] transition-colors hover:bg-[#f4f4f2] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:bg-[#1f1f1f] dark:hover:text-[#EDEDEC]"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <!-- Welcome screen (no messages yet) -->
                <div v-if="messages.length === 0 && !isStreaming" class="flex flex-1 flex-col overflow-y-auto p-4">
                    <div class="mb-4 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <Bot class="h-6 w-6 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <p class="mb-1 font-semibold">{{ t('chat.bubble_heading') }}</p>
                        <p class="text-xs leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            {{ t('chat.bubble_intro') }}
                        </p>
                    </div>

                    <!-- Disclaimer -->
                    <div class="mb-4 rounded-lg border border-[#e3e3e0] bg-[#f8f8f7] px-3 py-2 dark:border-[#2a2a28] dark:bg-[#111110]">
                        <p class="text-[10px] leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('chat.bubble_disclaimer_label') }}</span>
                            {{ t('chat.bubble_disclaimer_body') }}
                        </p>
                    </div>

                    <!-- Example prompts -->
                    <p class="mb-2 text-[10px] font-medium uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]">{{ t('chat.bubble_try_asking') }}</p>
                    <div class="flex flex-col gap-2">
                        <button
                            v-for="prompt in examplePrompts"
                            :key="prompt"
                            @click="handleSend(prompt)"
                            class="rounded-lg border border-[#e3e3e0] bg-white px-3 py-2.5 text-left text-xs text-[#1b1b18] transition-colors hover:border-[#c9c9c6] hover:bg-[#f8f8f7] dark:border-[#2a2a28] dark:bg-[#1f1f1f] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A] dark:hover:bg-[#2a2a28]"
                        >
                            {{ prompt }}
                        </button>
                    </div>
                </div>

                <!-- Messages list -->
                <div
                    v-else
                    ref="messagesContainer"
                    class="flex-1 overflow-y-auto px-3 py-3 space-y-3"
                >
                    <div
                        v-for="(msg, i) in messages"
                        :key="i"
                        :class="['flex gap-2', msg.role === 'user' ? 'flex-row-reverse' : 'flex-row']"
                    >
                        <div
                            :class="[
                                'flex h-6 w-6 shrink-0 items-center justify-center rounded-full',
                                msg.role === 'user'
                                    ? 'bg-[#1b1b18] dark:bg-[#EDEDEC]'
                                    : 'bg-[#f4f4f2] dark:bg-[#1f1f1f]',
                            ]"
                        >
                            <User v-if="msg.role === 'user'" class="h-3 w-3 text-white dark:text-[#1b1b18]" />
                            <Bot v-else class="h-3 w-3 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <div
                            :class="[
                                'max-w-[80%] rounded-xl px-3 py-2 text-xs leading-relaxed',
                                msg.role === 'user'
                                    ? 'bg-[#1b1b18] text-white dark:bg-[#EDEDEC] dark:text-[#1b1b18]'
                                    : 'bg-[#f4f4f2] text-[#1b1b18] dark:bg-[#1f1f1f] dark:text-[#EDEDEC]',
                            ]"
                        >
                            <p class="whitespace-pre-wrap">{{ msg.content }}</p>
                        </div>
                    </div>

                    <!-- Streaming bubble -->
                    <div v-if="isStreaming" class="flex flex-row gap-2">
                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <Bot class="h-3 w-3 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <div class="max-w-[80%] rounded-xl bg-[#f4f4f2] px-3 py-2 text-xs leading-relaxed text-[#1b1b18] dark:bg-[#1f1f1f] dark:text-[#EDEDEC]">
                            <p v-if="streamingContent" class="whitespace-pre-wrap">
                                {{ streamingContent }}<span class="ml-0.5 inline-block h-3.5 w-0.5 animate-pulse bg-current align-middle"></span>
                            </p>
                            <div v-else class="flex items-center gap-1 py-0.5">
                                <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#706f6c] dark:bg-[#A1A09A] [animation-delay:-0.3s]"></span>
                                <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#706f6c] dark:bg-[#A1A09A] [animation-delay:-0.15s]"></span>
                                <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#706f6c] dark:bg-[#A1A09A]"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Error -->
                    <p v-if="error" class="rounded-lg bg-red-50 px-3 py-2 text-xs text-red-600 dark:bg-red-950/30 dark:text-red-400">
                        {{ error }}
                    </p>
                </div>

                <!-- Input bar -->
                <div class="border-t border-[#e3e3e0] p-3 dark:border-[#2a2a28]">
                    <div class="flex items-end gap-2">
                        <textarea
                            v-model="inputText"
                            :placeholder="t('chat.bubble_placeholder')"
                            :disabled="isStreaming"
                            rows="1"
                            @keydown="handleKeydown"
                            class="flex-1 resize-none rounded-lg border border-[#e3e3e0] bg-white px-3 py-2 text-xs text-[#1b1b18] placeholder-[#A1A09A] outline-none transition-colors focus:border-[#c9c9c6] disabled:opacity-50 dark:border-[#2a2a28] dark:bg-[#1f1f1f] dark:text-[#EDEDEC] dark:focus:border-[#3E3E3A]"
                        />
                        <button
                            @click="handleSend()"
                            :disabled="isStreaming || !inputText.trim()"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#1b1b18] text-white transition-colors hover:bg-[#2d2d2a] disabled:opacity-40 dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                        >
                            <SendHorizontal class="h-3.5 w-3.5" />
                        </button>
                    </div>
                    <p class="mt-1.5 text-center text-[9px] text-[#A1A09A] dark:text-[#706f6c]">
                        {{ t('chat.bubble_footer') }}
                    </p>
                </div>
            </div>
        </Transition>

        <!-- ── Floating bubble button ────────────────────────── -->
        <button
            @click="toggleOpen"
            :class="[
                'relative flex h-14 w-14 items-center justify-center rounded-full shadow-lg transition-all duration-200 hover:scale-105 active:scale-95',
                isOpen
                    ? 'bg-[#2d2d2a] dark:bg-[#EDEDEC]'
                    : 'bg-[#1b1b18] dark:bg-[#EDEDEC]',
            ]"
            :aria-label="t('chat.bubble_toggle_label')"
        >
            <Transition
                enter-active-class="transition duration-150"
                leave-active-class="transition duration-150"
                enter-from-class="opacity-0 rotate-90 scale-50"
                enter-to-class="opacity-100 rotate-0 scale-100"
                leave-from-class="opacity-100 rotate-0 scale-100"
                leave-to-class="opacity-0 -rotate-90 scale-50"
                mode="out-in"
            >
                <X v-if="isOpen" class="h-5 w-5 text-white dark:text-[#1b1b18]" />
                <MessageSquare v-else class="h-5 w-5 text-white dark:text-[#1b1b18]" />
            </Transition>
            <!-- Unread dot: show when closed and has messages -->
            <span
                v-if="!isOpen && messages.length > 0"
                class="absolute right-0.5 top-0.5 h-3 w-3 rounded-full border-2 border-[#FDFDFC] bg-emerald-500 dark:border-[#0a0a0a]"
            ></span>
        </button>

    </div>
</template>
