<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import GuestLayout from '@/layouts/GuestLayout.vue';

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const contactUrl = computed(() => `/${currentLocale.value}/contact`);
</script>

<template>
    <GuestLayout>
        <Head :title="t('terms.page_title')" />

        <div class="mx-auto max-w-3xl px-6 py-16">

            <div class="mb-10">
                <h1 class="mb-3 text-4xl font-bold tracking-tight">{{ t('terms.title') }}</h1>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.last_updated') }}</p>
            </div>

            <div class="space-y-10 text-[#1b1b18] dark:text-[#EDEDEC]">

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s1_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('terms.s1_body_pre') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">kavuncuoglu.com</strong> {{ t('terms.s1_body_post') }}
                    </p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s2_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s2_p1') }}</p>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s2_p2') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s3_heading') }}</h2>
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50/60 px-4 py-3 dark:border-amber-800/40 dark:bg-amber-950/20">
                        <p class="text-sm font-medium text-amber-800 dark:text-amber-300">{{ t('terms.s3_warn') }}</p>
                    </div>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('terms.s3_p1_pre') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('terms.s3_p1_bold') }}</strong>{{ t('terms.s3_p1_post') }}
                    </p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('terms.s3_li1_pre') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('terms.s3_li1_bold') }}</strong> {{ t('terms.s3_li1_post') }}</li>
                        <li>{{ t('terms.s3_li2') }}</li>
                        <li>{{ t('terms.s3_li3') }}</li>
                        <li>{{ t('terms.s3_li4') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s4_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s4_intro') }}</p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('terms.s4_li1') }}</li>
                        <li>{{ t('terms.s4_li2') }}</li>
                        <li>{{ t('terms.s4_li3') }}</li>
                        <li>{{ t('terms.s4_li4') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s5_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s5_intro') }}</p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('terms.s5_li1') }}</li>
                        <li>{{ t('terms.s5_li2') }}</li>
                        <li>{{ t('terms.s5_li3') }}</li>
                        <li>{{ t('terms.s5_li4') }}</li>
                        <li>{{ t('terms.s5_li5') }}</li>
                        <li>{{ t('terms.s5_li6') }}</li>
                        <li>{{ t('terms.s5_li7') }}</li>
                        <li>{{ t('terms.s5_li8') }}</li>
                        <li>{{ t('terms.s5_li9') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s6_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s6_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s7_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s7_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s8_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('terms.s8_body_pre') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('terms.s8_body_bold') }}</strong> {{ t('terms.s8_body_post') }}
                    </p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s9_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s9_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s10_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s10_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s11_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('terms.s11_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('terms.s12_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('terms.s12_body_pre') }} <a :href="contactUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('terms.s12_link') }}</a>{{ t('terms.s12_body_post') }}
                    </p>
                </section>

            </div>
        </div>
    </GuestLayout>
</template>
