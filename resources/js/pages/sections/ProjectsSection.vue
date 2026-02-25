<script setup lang="ts">
import { Github, ExternalLink } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const projects = [
    {
        title: 'Vue Softphone',
        description: 'Provider-independent Vue 2 softphone component supporting Amazon Connect, Twilio, and custom providers. Modular call-control panel with warm/cold transfer, conference calls, hold/mute, and built-in WebRTC diagnostics.',
        tags: ['Vue 2', 'Amazon Connect', 'Twilio', 'WebRTC'],
        gradient: 'from-slate-400 to-blue-600',
        github: 'https://github.com/jkavuncuoglu/vue-softphone',
        demo: null,
    },
    {
        title: 'Consumer Loan Shield API',
        description: 'Full-stack application for managing and safeguarding consumer loan data. Built with Laravel, Vue 3, TypeScript, and Docker — complete with Eloquent-backed REST API, queue processing, and containerised infrastructure.',
        tags: ['Laravel', 'Vue 3', 'TypeScript', 'Docker'],
        gradient: 'from-emerald-400 to-teal-600',
        github: 'https://github.com/jkavuncuoglu/consumer-loan-shield-api',
        demo: null,
    },
    {
        title: 'Contenta CMS',
        description: 'Production-grade CMS scaffold with domain-driven architecture, WebAuthn + TOTP 2FA, Spatie role/permission management, rich publishing models, and full E2E test coverage via Playwright.',
        tags: ['Laravel 12', 'Vue 3', 'WebAuthn', 'Playwright'],
        gradient: 'from-violet-400 to-purple-600',
        github: 'https://github.com/jkavuncuoglu/contenta-content-management-mobile',
        demo: null,
    },
];
</script>

<template>
    <section
        id="projects"
        class="bg-[#f9f9f8]/80 px-6 py-24 dark:bg-[#0f0f0f]/80"
    >
        <div class="mx-auto max-w-6xl">
            <h2 class="mb-12 text-center text-3xl font-bold">
                {{ t('welcome.projects_title') }}
            </h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="project in projects"
                    :key="project.title"
                    class="group flex flex-col overflow-hidden rounded-xl border border-[#e3e3e0] bg-white shadow-sm transition-all hover:-translate-y-1 hover:border-[#c9c9c6] hover:shadow-md dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                >
                    <!-- Gradient banner -->
                    <div
                        :class="`h-24 bg-gradient-to-br ${project.gradient}`"
                    ></div>

                    <!-- Card body -->
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="mb-3 text-lg font-semibold">
                            {{ project.title }}
                        </h3>
                        <p
                            class="mb-4 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ project.description }}
                        </p>
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span
                                v-for="tag in project.tags"
                                :key="tag"
                                class="rounded-full bg-[#f4f4f2] px-2.5 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ tag }}
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-4 border-t border-[#e3e3e0] pt-3 dark:border-[#2a2a28]"
                        >
                            <a
                                :href="project.github"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                            >
                                <Github class="h-3.5 w-3.5" />
                                {{ t('welcome.project_github') }}
                            </a>
                            <a
                                v-if="project.demo"
                                :href="project.demo"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                            >
                                <ExternalLink class="h-3.5 w-3.5" />
                                {{ t('welcome.project_demo') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
