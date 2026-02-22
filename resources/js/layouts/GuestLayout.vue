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
const localizedUrls = computed(() => (page.props.localizedUrls as Record<string, string>) ?? {});
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const homeUrl = computed(() => localizedUrls.value[currentLocale.value] ?? `/${currentLocale.value}`);
const chatUrl = computed(() => {
    const base = localizedUrls.value[currentLocale.value] ?? `/${currentLocale.value}`;
    return base.replace(/\/$/, '') + '/chat';
});
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
                        href="mailto:hello@kavuncuoglu.com"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Mail class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>
