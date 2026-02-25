<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Github, Linkedin, Mail } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const contactUrl = computed(() => `/${currentLocale.value}/contact`);
const aboutUrl = computed(() => `/${currentLocale.value}/about`);
const privacyUrl = computed(() => `/${currentLocale.value}/privacy-policy`);
const termsUrl = computed(() => `/${currentLocale.value}/terms-of-use`);
const gdprUrl = computed(() => `/${currentLocale.value}/gdpr`);
</script>

<template>
    <footer class="border-t border-[#e3e3e0] px-6 py-8 dark:border-[#1f1f1f]">
        <div class="mx-auto flex max-w-6xl flex-col gap-6">
            <div
                class="flex flex-col items-center justify-between gap-4 sm:flex-row"
            >
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('footer.rights', { year: new Date().getFullYear() }) }}
                </p>

                <nav
                    class="flex flex-wrap items-center justify-center gap-x-5 gap-y-1"
                    aria-label="Footer navigation"
                >
                    <Link
                        :href="aboutUrl"
                        class="text-xs whitespace-nowrap text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        About This Site
                    </Link>
                    <Link
                        :href="privacyUrl"
                        class="text-xs whitespace-nowrap text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        Privacy Policy
                    </Link>
                    <Link
                        :href="termsUrl"
                        class="text-xs whitespace-nowrap text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        Terms of Use
                    </Link>
                    <Link
                        :href="gdprUrl"
                        class="text-xs text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        GDPR
                    </Link>
                </nav>

                <div class="flex items-center gap-4">
                    <a
                        href="https://github.com/jkavuncuoglu/jkavuncuoglu"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        <Github class="h-5 w-5" />
                    </a>
                    <a
                        href="https://www.linkedin.com/in/jkavuncuoglu/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        <Linkedin class="h-5 w-5" />
                    </a>
                    <a
                        href="https://medium.com/@jkavuncuoglu"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        aria-label="Medium"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zm7.42 0c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.38-2.88-3.38-6.42s1.51-6.42 3.38-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"
                            />
                        </svg>
                    </a>
                    <Link
                        :href="contactUrl"
                        class="text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        <Mail class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </div>
    </footer>
</template>
