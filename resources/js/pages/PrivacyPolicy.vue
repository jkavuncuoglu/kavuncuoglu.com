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
        <Head :title="t('privacy.page_title')" />

        <div class="mx-auto max-w-3xl px-6 py-16">

            <div class="mb-10">
                <h1 class="mb-3 text-4xl font-bold tracking-tight">{{ t('privacy.title') }}</h1>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.last_updated') }}</p>
            </div>

            <div class="space-y-10 text-[#1b1b18] dark:text-[#EDEDEC]">

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s1_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s1_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s2_heading') }}</h2>

                    <h3 class="mb-2 mt-5 font-semibold">{{ t('privacy.s2_ga4_heading') }}</h3>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s2_ga4_p1') }}</p>
                    <ul class="ml-5 list-disc space-y-1 text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('privacy.s2_ga4_li1') }}</li>
                        <li>{{ t('privacy.s2_ga4_li2') }}</li>
                        <li>{{ t('privacy.s2_ga4_li3') }}</li>
                        <li>{{ t('privacy.s2_ga4_li4') }}</li>
                        <li>{{ t('privacy.s2_ga4_li5') }}</li>
                        <li>{{ t('privacy.s2_ga4_li6') }}</li>
                    </ul>
                    <p class="mt-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s2_ga4_p2') }}</p>

                    <h3 class="mb-2 mt-5 font-semibold">{{ t('privacy.s2_contact_heading') }}</h3>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s2_contact_body') }}</p>

                    <h3 class="mb-2 mt-5 font-semibold">{{ t('privacy.s2_ai_heading') }}</h3>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s2_ai_body') }}</p>

                    <h3 class="mb-2 mt-5 font-semibold">{{ t('privacy.s2_auth_heading') }}</h3>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s2_auth_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s3_heading') }}</h2>
                    <p class="mb-4 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s3_intro') }}</p>
                    <div class="overflow-x-auto rounded-lg border border-[#e3e3e0] dark:border-[#2a2a28]">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-[#e3e3e0] bg-[#f8f8f7] dark:border-[#2a2a28] dark:bg-[#111110]">
                                    <th class="px-4 py-3 text-left font-semibold">{{ t('privacy.s3_col_name') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ t('privacy.s3_col_provider') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ t('privacy.s3_col_purpose') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ t('privacy.s3_col_duration') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e3e3e0] text-[#706f6c] dark:divide-[#2a2a28] dark:text-[#A1A09A]">
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">XSRF-TOKEN</td>
                                    <td class="px-4 py-3">kavuncuoglu.com</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_xsrf_purpose') }}</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_dur_session') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">laravel_session</td>
                                    <td class="px-4 py-3">kavuncuoglu.com</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_session_purpose') }}</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_dur_2h') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">locale</td>
                                    <td class="px-4 py-3">kavuncuoglu.com</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_locale_purpose') }}</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_dur_1y') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">_ga</td>
                                    <td class="px-4 py-3">Google</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_ga_purpose') }}</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_dur_13m') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">_ga_*</td>
                                    <td class="px-4 py-3">Google</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_gas_purpose') }}</td>
                                    <td class="px-4 py-3">{{ t('privacy.s3_dur_13m') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="mt-4 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('privacy.s3_optout') }}
                        <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer" class="underline underline-offset-2 hover:opacity-70">{{ t('privacy.s3_optout_link') }}</a>{{ t('privacy.s3_optout_after') }}
                    </p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s4_heading') }}</h2>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s4_li1_label') }}</strong> {{ t('privacy.s4_li1_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s4_li2_label') }}</strong> {{ t('privacy.s4_li2_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s4_li3_label') }}</strong> {{ t('privacy.s4_li3_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s4_li4_label') }}</strong> {{ t('privacy.s4_li4_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s4_li5_label') }}</strong> {{ t('privacy.s4_li5_text') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s5_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s5_intro') }}</p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s5_li1_label') }}</strong> {{ t('privacy.s5_li1_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s5_li2_label') }}</strong> {{ t('privacy.s5_li2_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s5_li3_label') }}</strong> {{ t('privacy.s5_li3_text') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s6_heading') }}</h2>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s6_li1_label') }}</strong> {{ t('privacy.s6_li1_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s6_li2_label') }}</strong> {{ t('privacy.s6_li2_text') }}</li>
                        <li><strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('privacy.s6_li3_label') }}</strong> {{ t('privacy.s6_li3_text') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s7_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s7_intro') }}</p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('privacy.s7_li1') }}</li>
                        <li>{{ t('privacy.s7_li2') }}</li>
                        <li>{{ t('privacy.s7_li3') }}</li>
                        <li>{{ t('privacy.s7_li4') }}</li>
                        <li>{{ t('privacy.s7_li5') }}</li>
                        <li>{{ t('privacy.s7_li6') }}</li>
                    </ul>
                    <p class="mt-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('privacy.s7_footer') }} <a :href="`/${currentLocale}/gdpr`" class="underline underline-offset-2 hover:opacity-70">{{ t('privacy.s7_gdpr_link') }}</a>.
                    </p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s8_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s8_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s9_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s9_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s10_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('privacy.s10_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('privacy.s11_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('privacy.s11_body') }} <a :href="contactUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('privacy.s11_link') }}</a> {{ t('privacy.s11_after') }}
                    </p>
                </section>

            </div>
        </div>
    </GuestLayout>
</template>
