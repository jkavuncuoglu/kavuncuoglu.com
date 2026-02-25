<script setup lang="ts">
import CircuitBackground from '@/components/CircuitBackground.vue';
import GuestHeader from './GuestHeader.vue';
import GuestFooter from './GuestFooter.vue';
import ChatBubble from '@/components/ChatBubble.vue';

const props = withDefaults(
    defineProps<{
        fullHeight?: boolean;
        showFooter?: boolean;
    }>(),
    {
        fullHeight: false,
        showFooter: true,
    },
);
</script>

<template>
    <div
        :class="[
            'relative bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] tw-max-w-7xl',
            fullHeight
                ? 'flex h-screen flex-col overflow-hidden'
                : 'min-h-screen',
        ]"
    >
        <GuestHeader />

        <main class="max-w-7xl mx-auto" :class="fullHeight ? 'flex-1 overflow-hidden' : ''">
            <slot />
        </main>

        <GuestFooter v-if="showFooter" />

        <ChatBubble v-if="!props.fullHeight" />
    </div>
</template>
