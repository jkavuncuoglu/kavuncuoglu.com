<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import GuestLayout from '@/layouts/GuestLayout.vue';

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const contactUrl = computed(() => `/${currentLocale.value}/contact`);
const privacyUrl = computed(() => `/${currentLocale.value}/privacy-policy`);
</script>

<template>
    <GuestLayout>
        <Head :title="t('gdpr.page_title')" />

        <div class="mx-auto max-w-3xl px-6 py-16">

            <div class="mb-10">
                <h1 class="mb-3 text-4xl font-bold tracking-tight">{{ t('gdpr.title') }}</h1>
                <p class="mb-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.last_updated') }}</p>
                <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('gdpr.intro_pre') }} <a :href="privacyUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.intro_privacy_link') }}</a>
                    {{ t('gdpr.intro_post') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.intro_bold') }}</strong>{{ t('gdpr.intro_after') }}
                </p>
            </div>

            <div class="space-y-10 text-[#1b1b18] dark:text-[#EDEDEC]">

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s1_heading') }}</h2>
                    <div class="rounded-xl border border-[#e3e3e0] bg-[#f8f8f7] p-5 dark:border-[#2a2a28] dark:bg-[#111110]">
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s1_label_controller') }}</strong> J. Kavuncuoglu<br/>
                            <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s1_label_website') }}</strong> kavuncuoglu.com<br/>
                            <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s1_label_contact') }}</strong> {{ t('gdpr.s1_contact_pre') }} <a :href="contactUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s1_contact_link') }}</a>
                        </p>
                    </div>
                    <p class="mt-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s1_body') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s2_heading') }}</h2>
                    <p class="mb-4 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s2_intro') }}</p>

                    <div class="space-y-4">
                        <div class="rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mb-1 flex items-center gap-2">
                                <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Art. 6(1)(f)</span>
                                <span class="font-semibold">{{ t('gdpr.s2_b1_title') }}</span>
                            </div>
                            <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s2_b1_body') }}</p>
                        </div>

                        <div class="rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mb-1 flex items-center gap-2">
                                <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Art. 6(1)(b)</span>
                                <span class="font-semibold">{{ t('gdpr.s2_b2_title') }}</span>
                            </div>
                            <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s2_b2_body') }}</p>
                        </div>

                        <div class="rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mb-1 flex items-center gap-2">
                                <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Art. 6(1)(c)</span>
                                <span class="font-semibold">{{ t('gdpr.s2_b3_title') }}</span>
                            </div>
                            <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s2_b3_body') }}</p>
                        </div>

                        <div class="rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mb-1 flex items-center gap-2">
                                <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Art. 6(1)(a)</span>
                                <span class="font-semibold">{{ t('gdpr.s2_b4_title') }}</span>
                            </div>
                            <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s2_b4_body') }}</p>
                        </div>
                    </div>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s3_heading') }}</h2>
                    <p class="mb-4 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('gdpr.s3_intro_pre') }} <a :href="contactUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s3_intro_link') }}</a>{{ t('gdpr.s3_intro_post') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s3_intro_bold') }}</strong>{{ t('gdpr.s3_intro_after') }}
                    </p>

                    <div class="space-y-3">
                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">📋</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r1_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r1_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">✏️</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r2_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r2_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">🗑️</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r3_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r3_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">⏸️</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r4_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r4_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">📦</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r5_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r5_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">🚫</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r6_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r6_body') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-lg border border-[#e3e3e0] p-4 dark:border-[#2a2a28]">
                            <div class="mt-0.5 shrink-0 text-lg">🤖</div>
                            <div>
                                <p class="mb-1 font-semibold">{{ t('gdpr.s3_r7_title') }}</p>
                                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s3_r7_body') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s4_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s4_intro') }}</p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>
                            <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s4_li1_label') }}</strong> {{ t('gdpr.s4_li1_text') }}
                        </li>
                        <li>
                            <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s4_li2_label') }}</strong> {{ t('gdpr.s4_li2_text') }}
                        </li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s5_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s5_p1') }}</p>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('gdpr.s5_p2_pre') }} <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s5_p2_link') }}</a>{{ t('gdpr.s5_p2_post') }}
                    </p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s6_heading') }}</h2>
                    <p class="mb-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('gdpr.s6_intro_pre') }} <a :href="privacyUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s6_intro_link') }}</a>{{ t('gdpr.s6_intro_post') }}
                    </p>
                    <ul class="ml-5 list-disc space-y-2 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <li>{{ t('gdpr.s6_li1') }}</li>
                        <li>{{ t('gdpr.s6_li2') }}</li>
                        <li>{{ t('gdpr.s6_li3') }}</li>
                    </ul>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s7_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('gdpr.s7_body_pre') }} <a href="https://edpb.europa.eu/about-edpb/about-edpb/members_en" target="_blank" rel="noopener noreferrer" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s7_edpb_link') }}</a>
                        {{ t('gdpr.s7_body_mid') }} <a href="https://ico.org.uk/make-a-complaint/" target="_blank" rel="noopener noreferrer" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s7_ico_link') }}</a>{{ t('gdpr.s7_body_post') }}
                    </p>
                    <p class="mt-3 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ t('gdpr.s7_encourage') }}</p>
                </section>

                <div class="h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>

                <section>
                    <h2 class="mb-3 text-xl font-semibold">{{ t('gdpr.s8_heading') }}</h2>
                    <p class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('gdpr.s8_body_pre') }} <a :href="contactUrl" class="underline underline-offset-2 hover:opacity-70">{{ t('gdpr.s8_body_link') }}</a>{{ t('gdpr.s8_body_post') }} <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('gdpr.s8_body_bold') }}</strong> {{ t('gdpr.s8_body_after') }}
                    </p>
                </section>

            </div>
        </div>
    </GuestLayout>
</template>
