<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { login } from '@/routes';
import { Github, Linkedin, Mail } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';

withDefaults(defineProps<{
    fullHeight?: boolean;
    showFooter?: boolean;
}>(), {
    fullHeight: false,
    showFooter: true,
});

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const homeUrl = computed(() => `/${currentLocale.value}`);
const chatUrl = computed(() => `/${currentLocale.value}/chat`);
const contactUrl = computed(() => `/${currentLocale.value}/contact`);
</script>

<template>
    <div
        :class="[
            'bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]',
            fullHeight ? 'h-screen flex flex-col overflow-hidden' : 'min-h-screen',
        ]"
    >
        <!-- Navigation -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-[#FDFDFC]/80 dark:bg-[#0a0a0a]/80 border-b border-[#e3e3e0] dark:border-[#1f1f1f]">
            <nav class="mx-auto max-w-6xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <Link :href="homeUrl" class="text-lg font-semibold tracking-tight">JK</Link>
                    <div class="flex items-center gap-6">
                        <slot name="nav-items">
                            <Link :href="homeUrl" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">{{ t('nav.home') }}</Link>
                            <Link :href="chatUrl" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">{{ t('nav.chat') }}</Link>
                            <Link :href="contactUrl" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">{{ t('nav.contact') }}</Link>
                        </slot>
                        <LanguageSwitcher />
                        <div class="h-4 w-px bg-[#e3e3e0] dark:bg-[#3E3E3A]"></div>
                        <Link
                            v-if="page.props.auth.user"
                            href="/dashboard"
                            class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                        >
                            {{ t('nav.dashboard') }}
                        </Link>
                        <template v-else>
                            <Link
                                :href="login()"
                                class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                            >
                                {{ t('nav.login') }}
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>
        </header>

        <main :class="fullHeight ? 'flex-1 overflow-hidden' : ''">
            <slot />
        </main>

        <!-- Footer -->
        <footer v-if="showFooter" class="py-8 px-6 border-t border-[#e3e3e0] dark:border-[#1f1f1f]">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('footer.rights', { year: new Date().getFullYear() }) }}
                </p>
                <div class="flex items-center gap-4">
                    <a
                        href="https://github.com/jkavuncuoglu/jkavuncuoglu"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Github class="w-5 h-5" />
                    </a>
                    <a
                        href="https://www.linkedin.com/in/jkavuncuoglu/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Linkedin class="w-5 h-5" />
                    </a>
                    <a
                        href="https://medium.com/@jkavuncuoglu"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                        aria-label="Medium"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zm7.42 0c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.38-2.88-3.38-6.42s1.51-6.42 3.38-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/>
                        </svg>
                    </a>
                    <Link
                        :href="contactUrl"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Mail class="w-5 h-5" />
                    </Link>
                </div>
            </div>
        </footer>
    </div>
</template>
