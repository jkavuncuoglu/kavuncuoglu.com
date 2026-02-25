<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Github, ExternalLink } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

const { t } = useI18n();
const page = usePage();
const contactUrl = computed(() => `/${(page.props.locale as string) ?? 'en'}/contact`);

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
    <GuestLayout>
        <Head title="Projects — Jeremy C Kavuncuoglu">
            <meta
                name="description"
                content="Open source and personal projects by Jeremy Kavuncuoglu — Vue softphone, Laravel applications, and more."
            />
        </Head>

        <div class="mx-auto max-w-5xl px-6 py-16 md:py-24">

            <!-- ─── Hero ─────────────────────────────────────────── -->
            <div class="mb-16 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium tracking-widest text-[#706f6c] uppercase dark:border-[#2a2a28] dark:text-[#A1A09A]"
                >
                    Open Source &amp; Personal Work
                </span>
                <h1 class="mb-4 text-4xl font-bold tracking-tight md:text-5xl">
                    Projects
                </h1>
                <p class="mx-auto mb-8 max-w-2xl text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    A selection of open-source and personal projects — each one a real-world solution to a real-world problem,
                    built with production quality and published for the community.
                </p>

                <!-- Stat pills -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">3 Public Repos</span>
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">MIT Licensed</span>
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">Vue · Laravel · WebRTC</span>
                </div>
            </div>

            <!-- ─── Section label ─────────────────────────────────── -->
            <div class="mb-8 flex items-center gap-4">
                <h2 class="shrink-0 text-sm font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">Featured Projects</h2>
                <div class="h-px flex-1 bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
            </div>

            <!-- ─── Project cards ─────────────────────────────────── -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="project in projects"
                    :key="project.title"
                    class="group flex flex-col overflow-hidden rounded-xl border border-[#e3e3e0] bg-white shadow-sm transition-all hover:-translate-y-1 hover:border-[#c9c9c6] hover:shadow-md dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                >
                    <!-- Gradient banner -->
                    <div :class="`h-24 bg-gradient-to-br ${project.gradient}`"></div>

                    <!-- Card body -->
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="mb-3 text-lg font-semibold">{{ project.title }}</h3>
                        <p class="mb-4 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
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
                        <div class="flex items-center gap-4 border-t border-[#e3e3e0] pt-3 dark:border-[#2a2a28]">
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

            <!-- ─── View all on GitHub ────────────────────────────── -->
            <div class="mt-8 flex justify-center">
                <a
                    href="https://github.com/jkavuncuoglu"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-lg border border-[#e3e3e0] bg-[#FDFDFC] px-6 py-3 text-sm font-medium transition-colors hover:bg-[#f4f4f2] dark:border-[#2a2a28] dark:bg-[#0a0a0a] dark:hover:bg-[#1f1f1f]"
                >
                    <Github class="h-4 w-4" />
                    View all on GitHub
                </a>
            </div>

            <!-- ─── CTA strip ─────────────────────────────────────── -->
            <div class="mt-16 rounded-2xl border border-[#e3e3e0] bg-[#f8f8f7] p-8 text-center dark:border-[#2a2a28] dark:bg-[#111110]">
                <h2 class="mb-3 text-2xl font-bold tracking-tight">Have a project in mind?</h2>
                <p class="mb-6 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    I'm always open to interesting problems. Let's talk about what we could build together.
                </p>
                <a
                    :href="contactUrl"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                >
                    Get in touch <span aria-hidden="true">→</span>
                </a>
            </div>

        </div>
    </GuestLayout>
</template>
