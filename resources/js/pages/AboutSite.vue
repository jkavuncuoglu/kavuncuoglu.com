<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

const page = usePage();
const contactUrl = computed(() => `/${(page.props.locale as string) ?? 'en'}/contact`);
</script>

<template>
    <GuestLayout>
        <Head title="About This Site" />

        <div class="mx-auto px-6 py-16">

            <!-- Hero -->
            <div class="mb-14">
                <span class="mb-4 inline-block rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium tracking-widest text-[#706f6c] uppercase dark:border-[#2a2a28] dark:text-[#A1A09A]">
                    Built in the Open
                </span>
                <h1 class="mb-4 text-4xl font-bold tracking-tight">About This Site</h1>
                <p class="text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    This personal portfolio is a living proof-of-concept — every feature is production-grade, real, and running the same stack I use professionally. Below is an honest breakdown of the technologies powering it.
                </p>
            </div>

            <!-- Section: Backend -->
            <section class="mb-12">
                <h2 class="mb-1 text-xs font-semibold tracking-widest text-[#706f6c] uppercase dark:text-[#A1A09A]">Backend</h2>
                <div class="mb-6 h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Laravel 12</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">PHP 8.2</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            The backbone of the application. Handles routing, middleware, Eloquent ORM, queued jobs, and all server-side logic. Laravel 12 brings the latest conventions in clean, expressive PHP.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Inertia.js 2</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Server-Driven SPA</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Bridges Laravel and Vue without a dedicated REST API layer. Pages are server-rendered responses that hydrate Vue components — giving the feel of an SPA with the simplicity of traditional MVC.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Laravel Fortify</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">+ Sanctum</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Full authentication stack: registration, login, two-factor authentication (TOTP), email verification, and session-based API tokens via Sanctum.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Spatie Media Library</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">v11</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Handles all file association, storage, and retrieval for uploaded knowledge-base documents — including PDF, Word, and image assets.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section: AI & Machine Learning -->
            <section class="mb-12">
                <h2 class="mb-1 text-xs font-semibold tracking-widest text-[#706f6c] uppercase dark:text-[#A1A09A]">AI &amp; Machine Learning</h2>
                <div class="mb-6 h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-blue-200/60 bg-blue-50/40 p-5 backdrop-blur-sm dark:border-blue-900/40 dark:bg-blue-950/20">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">NeuronAI</span>
                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">v2.12</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            A PHP-native AI orchestration framework that powers the conversational assistant. Manages prompt construction, context windowing, tool use, and streaming responses — all from within Laravel.
                        </p>
                    </div>

                    <div class="rounded-xl border border-blue-200/60 bg-blue-50/40 p-5 backdrop-blur-sm dark:border-blue-900/40 dark:bg-blue-950/20">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Ollama</span>
                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">Local Inference</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Runs large language models entirely on-premise — no cloud API, no data leaving the server. Used for both chat completions and generating vector embeddings for the RAG knowledge base.
                        </p>
                    </div>

                    <div class="rounded-xl border border-blue-200/60 bg-blue-50/40 p-5 backdrop-blur-sm dark:border-blue-900/40 dark:bg-blue-950/20 sm:col-span-2">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">RAG — Retrieval-Augmented Generation</span>
                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">Vector Search</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            The AI assistant is grounded in a private knowledge base of uploaded documents (PDF, Word, images, plain text). Documents are chunked, embedded into high-dimensional vectors via Ollama, and stored in MySQL. At query time, the most semantically relevant chunks are retrieved and injected into the prompt context — giving the model accurate, up-to-date, private knowledge without hallucination.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Document Parsers</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Ingests knowledge-base uploads in any format: <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">smalot/pdfparser</strong> for PDF, <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">phpoffice/phpword</strong> for .docx, and <strong class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Tesseract OCR</strong> for scanned images.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section: Frontend -->
            <section class="mb-12">
                <h2 class="mb-1 text-xs font-semibold tracking-widest text-[#706f6c] uppercase dark:text-[#A1A09A]">Frontend</h2>
                <div class="mb-6 h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Vue 3.5</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Composition API</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            All UI is built with Vue 3's Composition API and <code class="rounded bg-[#f0f0ef] px-1 text-xs dark:bg-[#1f1f1e]">&lt;script setup&gt;</code>. TypeScript-first throughout, with strict typing enforced by vue-tsc.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Tailwind CSS v4</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Utility-First</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            The latest major version of Tailwind — now CSS-native with a Vite plugin, no PostCSS config required. Every layout, colour, and responsive breakpoint is expressed in utility classes.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">shadcn/vue</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">reka-ui</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Accessible, unstyled primitives from reka-ui (the Vue port of Radix UI), composed into styled components using shadcn conventions. Buttons, dialogs, inputs, and tooltips are all accessibility-compliant.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Vite 7</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">+ Laravel Vite Plugin</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Instant HMR in development and highly optimised code-split bundles in production. The Laravel Vite plugin handles asset manifest injection and server-side asset URL resolution automatically.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">VueUse</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">v12</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            A comprehensive library of composable Vue utilities — used for reactive media queries, clipboard access, event listeners, and browser API abstractions throughout the UI.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">vue-i18n</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">4 Languages</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Full internationalisation in English, German, Turkish, and Spanish. Locale detection from the browser's <code class="rounded bg-[#f0f0ef] px-1 text-xs dark:bg-[#1f1f1e]">Accept-Language</code> header with cookie persistence and a locale switcher in the nav.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section: Design & UX -->
            <section class="mb-12">
                <h2 class="mb-1 text-xs font-semibold tracking-widest text-[#706f6c] uppercase dark:text-[#A1A09A]">Design &amp; UX</h2>
                <div class="mb-6 h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60 sm:col-span-2">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Animated Circuit Background</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Custom SVG Engine</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            The PCB-style background is a fully custom, zero-dependency SVG animation engine written in ~300 lines of TypeScript. A seeded PRNG generates deterministic trace layouts with rounded bezier corners, per-trace opacity variation, and IC chip elements. Electricity streaks use burst-mode CSS animation — each lit trace fires 2–4 data-packet flashes that walk the path from start to end, driven by a coordinated timer system with stale-timeout cancellation.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Dark Mode</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            System-preference-aware dark mode via Tailwind's <code class="rounded bg-[#f0f0ef] px-1 text-xs dark:bg-[#1f1f1e]">dark:</code> variant, with a manual toggle persisted to <code class="rounded bg-[#f0f0ef] px-1 text-xs dark:bg-[#1f1f1e]">localStorage</code>. Colours, glows, and SVG filters all adapt seamlessly.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Lucide Icons</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Consistent, accessible SVG icon set — tree-shaken per-icon to minimise bundle size. Every interactive element has an accompanying accessible label.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section: Infrastructure -->
            <section class="mb-12">
                <h2 class="mb-1 text-xs font-semibold tracking-widest text-[#706f6c] uppercase dark:text-[#A1A09A]">Infrastructure</h2>
                <div class="mb-6 h-px bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Docker Compose</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Laravel Sail</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            The entire environment — PHP-FPM, MySQL, Redis, Mailpit, and Ollama — runs in Docker via Laravel Sail. One command spins up a fully reproducible, production-like dev environment.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">MySQL 8</span>
                            <span class="rounded-full bg-[#f0f0ef] px-2 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1e] dark:text-[#A1A09A]">Vector Embeddings</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Stores document chunks alongside their Ollama-generated vector embeddings as JSON arrays. Cosine similarity is computed at query time to surface the most relevant knowledge-base excerpts.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Laravel Telescope</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Real-time introspection of requests, queries, jobs, and exceptions during development. Indispensable for debugging AI streaming responses and background document-processing pipelines.
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-5 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-base font-semibold">Laravel Wayfinder</span>
                        </div>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Auto-generates type-safe TypeScript route helper functions from Laravel's route definitions. Eliminates hardcoded URL strings from the frontend and catches route regressions at compile time.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Closing note -->
            <div class="rounded-xl border border-[#e3e3e0] bg-[#f8f8f7] p-6 dark:border-[#2a2a28] dark:bg-[#111110]">
                <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    Every dependency listed here is running in production on this site right now — not a sample project, not a tutorial clone. If you have questions about any implementation detail, or want to work together,
                    <a :href="contactUrl" class="font-medium text-[#1b1b18] underline underline-offset-2 hover:opacity-70 dark:text-[#EDEDEC]">get in touch</a>.
                </p>
            </div>

        </div>
    </GuestLayout>
</template>
