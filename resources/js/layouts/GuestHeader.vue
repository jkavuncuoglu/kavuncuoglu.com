<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { login } from '@/routes';
import { Sun, Moon, Menu } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { computed, ref } from 'vue';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
import { useAppearance } from '@/composables/useAppearance';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const homeUrl = computed(() => `/${currentLocale.value}`);
const aboutUrl = computed(() => `/${currentLocale.value}/about-me`);
const skillsUrl = computed(() => `/${currentLocale.value}/skills`);
const projectsUrl = computed(() => `/${currentLocale.value}/projects`);
const contactUrl = computed(() => `/${currentLocale.value}/contact`);

const { resolvedAppearance, updateAppearance } = useAppearance();
const toggleDark = () =>
    updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
const mobileMenuOpen = ref(false);
</script>

<template>
    <header
        class="sticky top-0 z-50 w-full border-b border-[#e3e3e0] bg-[#FDFDFC]/80 backdrop-blur-md dark:border-[#1f1f1f] dark:bg-[#0a0a0a]/80"
    >
        <nav class="flex h-28 w-full items-center px-6">
            <div class="flex w-full items-center justify-between">
                <Link
                    :href="homeUrl"
                    class="text-4xl font-semibold tracking-tight"
                    >JKAVUNCUOGLU</Link
                >

                <!-- Desktop nav (md+) -->
                <div class="hidden items-center gap-6 md:flex">
                    <Link
                        :href="homeUrl"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >{{ t('nav.home') }}</Link
                    >
                    <Link
                        :href="aboutUrl"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >{{ t('nav.about_me') }}</Link>
                    <Link
                        :href="skillsUrl"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >{{ t('nav.skills') }}</Link>
                    <Link
                        :href="projectsUrl"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >{{ t('nav.projects') }}</Link>
                    <Link
                        :href="contactUrl"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >{{ t('nav.contact') }}</Link
                    >
                    <LanguageSwitcher />
                    <button
                        @click="toggleDark"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        :aria-label="
                            resolvedAppearance === 'dark'
                                ? t('nav.switch_light')
                                : t('nav.switch_dark')
                        "
                    >
                        <Sun v-if="resolvedAppearance === 'dark'" class="h-4 w-4" />
                        <Moon v-else class="h-4 w-4" />
                    </button>
                    <div class="h-4 w-px bg-[#e3e3e0] dark:bg-[#3E3E3A]"></div>
                    <Link
                        v-if="page.props.auth.user"
                        href="/dashboard"
                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        {{ t('nav.dashboard') }}
                    </Link>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('nav.login') }}
                        </Link>
                    </template>
                </div>

                <!-- Mobile controls (< md) -->
                <div class="flex items-center gap-2 md:hidden">
                    <LanguageSwitcher />
                    <button
                        @click="toggleDark"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        :aria-label="
                            resolvedAppearance === 'dark'
                                ? t('nav.switch_light')
                                : t('nav.switch_dark')
                        "
                    >
                        <Sun v-if="resolvedAppearance === 'dark'" class="h-4 w-4" />
                        <Moon v-else class="h-4 w-4" />
                    </button>
                    <Sheet v-model:open="mobileMenuOpen">
                        <SheetTrigger :as-child="true">
                            <button
                                class="flex h-8 w-8 items-center justify-center rounded-md text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                            >
                                <Menu class="h-5 w-5" />
                            </button>
                        </SheetTrigger>
                        <SheetContent side="right" class="w-64 p-6">
                            <div class="mt-6 flex flex-col gap-5">
                                <Link
                                    :href="homeUrl"
                                    @click="mobileMenuOpen = false"
                                    class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                    >{{ t('nav.home') }}</Link
                                >
                                <Link
                                    :href="aboutUrl"
                                    @click="mobileMenuOpen = false"
                                    class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                >{{ t('nav.about_me') }}</Link
                                >
                                <Link
                                    :href="skillsUrl"
                                    @click="mobileMenuOpen = false"
                                    class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                >{{ t('nav.skills') }}</Link>
                                <Link
                                    :href="projectsUrl"
                                    @click="mobileMenuOpen = false"
                                    class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                >{{ t('nav.projects') }}</Link>
                                <Link
                                    :href="contactUrl"
                                    @click="mobileMenuOpen = false"
                                    class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                    >{{ t('nav.contact') }}</Link
                                >
                                <div
                                    class="border-t border-[#e3e3e0] pt-4 dark:border-[#1f1f1f]"
                                >
                                    <Link
                                        v-if="page.props.auth.user"
                                        href="/dashboard"
                                        @click="mobileMenuOpen = false"
                                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                        >{{ t('nav.dashboard') }}</Link
                                    >
                                    <Link
                                        v-else
                                        :href="login()"
                                        @click="mobileMenuOpen = false"
                                        class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                                        >{{ t('nav.login') }}</Link
                                    >
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </nav>
    </header>
</template>
