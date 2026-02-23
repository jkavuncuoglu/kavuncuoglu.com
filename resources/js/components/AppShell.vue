<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { SidebarProvider } from '@/components/ui/sidebar';
import type { AppShellVariant } from '@/types';
import CircuitBackground from '@/components/CircuitBackground.vue';

type Props = {
    variant?: AppShellVariant;
};

defineProps<Props>();

const isOpen = usePage().props.sidebarOpen;
</script>

<template>
    <div v-if="variant === 'header'" class="relative flex min-h-screen w-full flex-col">
        <CircuitBackground />
        <slot />
    </div>
    <div v-else class="relative min-h-screen">
        <CircuitBackground />
        <SidebarProvider :default-open="isOpen">
            <slot />
        </SidebarProvider>
    </div>
</template>
