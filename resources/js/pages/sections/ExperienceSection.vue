<script setup lang="ts">
import { Briefcase } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';

const { t } = useI18n();

const experience = computed(() => [
    {
        period: t('welcome.exp1_period'),
        role: t('welcome.exp1_role'),
        company: t('welcome.exp1_company'),
        desc: t('welcome.exp1_desc'),
    },
    {
        period: t('welcome.exp2_period'),
        role: t('welcome.exp2_role'),
        company: t('welcome.exp2_company'),
        desc: t('welcome.exp2_desc'),
    },
    {
        period: t('welcome.exp3_period'),
        role: t('welcome.exp3_role'),
        company: t('welcome.exp3_company'),
        desc: t('welcome.exp3_desc'),
    },
    {
        period: t('welcome.exp4_period'),
        role: t('welcome.exp4_role'),
        company: t('welcome.exp4_company'),
        desc: t('welcome.exp4_desc'),
    },
]);
</script>

<template>
    <section id="experience" class="px-6 py-24">
        <div class="mx-auto max-w-4xl">
            <h2 class="mb-12 text-3xl font-bold">
                {{ t('welcome.experience_title') }}
            </h2>

            <div class="relative">
                <!-- Vertical line -->
                <div
                    class="absolute top-0 bottom-0 left-2 w-0.5 bg-[#e3e3e0] dark:bg-[#2a2a28]"
                ></div>

                <ol role="list" class="space-y-8">
                    <li
                        v-for="(exp, index) in experience"
                        :key="index"
                        class="relative pl-10"
                    >
                        <!-- Dot -->
                        <div
                            class="absolute top-4 left-0 flex h-4 w-4 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-white dark:border-[#2a2a28] dark:bg-[#0a0a0a]"
                        >
                            <div
                                class="h-1.5 w-1.5 rounded-full bg-[#706f6c] dark:bg-[#A1A09A]"
                            ></div>
                        </div>

                        <!-- Card -->
                        <div
                            class="rounded-xl border border-[#e3e3e0] bg-white p-6 shadow-sm dark:border-[#2a2a28] dark:bg-[#161615]"
                        >
                            <div
                                class="mb-3 flex flex-wrap items-center gap-3"
                            >
                                <div
                                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                                >
                                    <Briefcase
                                        class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]"
                                    />
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ exp.role }}</h3>
                                    <p
                                        class="text-sm text-[#706f6c] dark:text-[#A1A09A]"
                                    >
                                        {{ exp.company }}
                                    </p>
                                </div>
                                <time
                                    class="rounded-full bg-[#f4f4f2] px-3 py-1 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                                >
                                    {{ exp.period }}
                                </time>
                            </div>
                            <p
                                class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                            >
                                {{ exp.desc }}
                            </p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </section>
</template>
