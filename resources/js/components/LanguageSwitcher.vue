<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { Check, ChevronDown, Globe } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

const page = usePage();

const localizedUrls = computed(
    () => (page.props.localizedUrls as Record<string, string>) ?? {},
);
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');

const localeLabels: Record<string, string> = {
    ar: 'العربية',
    de: 'Deutsch',
    en: 'English',
    es: 'Español',
    fr: 'France',
    it: 'Italiano',
    nl: 'Nederlands',
    pt: 'Português',
    tr: 'Türkçe',
};

const open = ref(false);

function switchLocale(locale: string) {
    open.value = false;
    const url = localizedUrls.value[locale] ?? `/${locale}`;
    router.visit(url, { preserveScroll: true });
}
</script>

<template>
    <DropdownMenu v-model:open="open">
        <DropdownMenuTrigger
            class="flex items-center gap-1.5 rounded px-2 py-1 text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] focus:outline-none dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
        >
            <Globe class="h-4 w-4" />
            <span class="font-medium uppercase">{{ currentLocale }}</span>
            <ChevronDown class="h-3 w-3 opacity-60" />
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="min-w-[130px]">
            <DropdownMenuItem
                v-for="(label, locale) in localeLabels"
                :key="locale"
                class="flex cursor-pointer items-center justify-between gap-3"
                @click="switchLocale(locale)"
            >
                <span>{{ label }}</span>
                <Check
                    v-if="locale === currentLocale"
                    class="h-3.5 w-3.5 text-[#706f6c] dark:text-[#A1A09A]"
                />
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
