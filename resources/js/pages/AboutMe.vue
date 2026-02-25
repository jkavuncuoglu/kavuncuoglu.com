<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { BarChart2, BrainCircuit, ChevronDown, ChevronUp, Cloud, Code2, Layers, Rocket, Shield } from 'lucide-vue-next';

const { t } = useI18n();
const page = usePage();
const contactUrl = computed(() => `/${(page.props.locale as string) ?? 'en'}/contact`);

const openFaq = ref<number | null>(null);
const toggleFaq = (groupIndex: number, itemIndex: number) => {
    const key = groupIndex * 100 + itemIndex;
    openFaq.value = openFaq.value === key ? null : key;
};
const isFaqOpen = (groupIndex: number, itemIndex: number) => {
    return openFaq.value === groupIndex * 100 + itemIndex;
};

const expertiseCards = [
    {
        icon: Code2,
        title: 'Laravel & PHP',
        description: 'Scalable backend architecture, domain-driven design, and clean API contracts.',
        tag: 'Backend',
    },
    {
        icon: Layers,
        title: 'Vue.js & TypeScript',
        description: 'Performant SPAs with Composition API, strict typing, and Inertia integration.',
        tag: 'Frontend',
    },
    {
        icon: Cloud,
        title: 'AWS & DevOps',
        description: 'Serverless, ECS, Terraform, and automated CI/CD from commit to production.',
        tag: 'Infrastructure',
    },
    {
        icon: BrainCircuit,
        title: 'Amazon Connect & AI',
        description: 'Contact-centre integrations, RAG pipelines, and on-premise LLM deployments.',
        tag: 'Speciality',
    },
];

const faqGroups = [
    {
        category: 'Backend Architecture',
        items: [
            {
                question: 'How do you architect large-scale Laravel applications?',
                answer: 'I design Laravel apps with modularity and long-term maintainability as first priorities. That means service layers, domain-driven organisation, and event-driven patterns where appropriate. Background queues handle anything heavy, Redis caches the hot paths, and Eloquent stays lean — no N+1s in production, ever. When traffic demands it, I layer in read replicas and optional Octane for sub-millisecond response.',
            },
            {
                question: 'How do you design APIs that are both scalable and developer-friendly?',
                answer: 'Versioned endpoints, consistent error envelopes, meaningful HTTP semantics, and self-documenting schemas (OpenAPI where warranted). Rate limiting and idempotency keys prevent abuse without punishing legitimate clients. I default to REST but reach for GraphQL when the client\'s data-fetching patterns justify the tooling cost. Pagination, sparse fieldsets, and server-side filtering keep payloads sane at scale.',
            },
            {
                question: 'How do you structure large Vue.js codebases?',
                answer: 'Composition API with <script setup> throughout, feature-grouped directories rather than type-grouped ones, and composables for any stateful logic that\'s used in more than one place. Routes are lazy-loaded by default; heavy components get defineAsyncComponent. Pinia for shared state only when prop-drilling genuinely hurts. TypeScript strict mode and vue-tsc in CI catch regressions early.',
            },
        ],
    },
    {
        category: 'Infrastructure & DevOps',
        items: [
            {
                question: 'When do you choose serverless over traditional deployments?',
                answer: 'Serverless — Lambda, Fargate, App Runner — earns its place when workloads are event-driven, traffic is spiky, or you genuinely want to escape capacity-planning. I weigh cold-start latency, execution cost per invocation, and observability requirements before deciding. For long-running PHP processes, ECS or EC2 Auto Scaling is often the better trade-off. I build both and pick based on the numbers, not hype.',
            },
            {
                question: 'What does your CI/CD pipeline look like in practice?',
                answer: 'GitHub Actions runs lint, static analysis (PHPStan level 8 + vue-tsc), and the full test suite on every push. Passing builds trigger Docker image builds pushed to ECR, followed by blue/green deployments via CodeDeploy or ECS rolling updates. Infrastructure changes go through Terraform plan reviews before apply. The goal: every merge to main is production-ready and deployed within minutes, not hours.',
            },
        ],
    },
    {
        category: 'Security & Auth',
        items: [
            {
                question: 'How do you handle authentication in SPAs without compromising security?',
                answer: 'For Inertia-based SPAs on the same domain, Laravel Sanctum\'s cookie-based sessions are the right tool — CSRF protection built in, no token management on the client. For true API consumers I issue short-lived JWTs with refresh-token rotation, store nothing sensitive in localStorage, and enforce HTTPS + secure/httpOnly cookies. Two-factor via TOTP (Fortify) adds the second layer where needed.',
            },
            {
                question: 'How do you optimise performance in Laravel applications?',
                answer: 'It starts with measurement — Telescope, Clockwork, and EXPLAIN on slow queries before touching a line of code. Indexed foreign keys, eager-loaded relationships, and Redis-backed cache layers usually cover 80% of gains. The remaining 20% is queue offloading, chunked batch processing, and — when the data justifies it — read replicas. I profile production, not just staging.',
            },
        ],
    },
    {
        category: 'Business & AI',
        items: [
            {
                question: 'How do you translate business requirements into technical solutions?',
                answer: 'I spend time understanding the underlying business problem before writing a single line of code. That means talking to stakeholders, mapping user journeys, and identifying the metrics that define success. Architecture decisions flow from those constraints — not the other way around. The deliverable isn\'t software; it\'s a measurable outcome. The software is just how we get there.',
            },
            {
                question: 'How do you integrate AI into existing Laravel systems?',
                answer: 'I wire AI into the request lifecycle via queued jobs so it never blocks the user. NeuronAI handles orchestration — prompt construction, context windowing, RAG retrieval — while Ollama keeps inference on-premise for cost and data-privacy reasons. Streaming responses over SSE give users immediate feedback. The entire pipeline is observable: every LLM call, token count, and retrieval score is logged and traceable.',
            },
            {
                question: 'How have you integrated Amazon Connect with custom applications?',
                answer: 'I use the Connect Streams SDK to embed the CCP directly into internal dashboards, attach contact attributes in real time, and surface caller context to agents before they say hello. Lambda handles contact flows for IVR logic, DynamoDB lookups, and CRM writes. Kinesis streams feed contact trace records into analytics pipelines so ops teams have live queue metrics without polling.',
            },
        ],
    },
];
</script>

<template>
    <GuestLayout>
        <Head title="About Me — Jeremy C Kavuncuoglu">
            <meta
                name="description"
                content="Senior Full-Stack Developer & Cloud Consultant. Learn about Jeremy's expertise in Laravel, Vue.js, AWS, DevOps, and Amazon Connect."
            />
        </Head>

        <div class="mx-auto max-w-5xl px-6 py-16 md:py-24">

            <!-- ─── Hero ─────────────────────────────────────────── -->
            <div class="mb-16 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium tracking-widest text-[#706f6c] uppercase dark:border-[#2a2a28] dark:text-[#A1A09A]"
                >
                    Available for collaboration
                </span>
                <h1 class="mb-4 text-4xl font-bold tracking-tight md:text-5xl">
                    Hi, I'm Jeremy Kavuncuoglu
                </h1>
                <p class="mx-auto mb-8 max-w-2xl text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    Senior Full-Stack Developer &amp; Cloud Consultant specialising in
                    Laravel, Vue.js, AWS, DevOps, and Amazon Connect integrations.
                    I connect engineering rigour with business outcomes.
                </p>

                <!-- Stat pills -->
                <div class="mb-8 flex flex-wrap items-center justify-center gap-2">
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">10+ Years Experience</span>
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">AWS Certified</span>
                    <span class="rounded-full border border-[#e3e3e0] px-3 py-1 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">Full-Stack &amp; DevOps</span>
                </div>

                <!-- CTA buttons -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a
                        :href="contactUrl"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        Get in touch <span aria-hidden="true">→</span>
                    </a>
                    <a
                        href="#expertise"
                        class="inline-flex items-center gap-2 rounded-lg border border-[#e3e3e0] bg-[#FDFDFC] px-6 py-3 text-sm font-medium transition-colors hover:bg-[#f4f4f2] dark:border-[#2a2a28] dark:bg-[#0a0a0a] dark:hover:bg-[#1f1f1f]"
                    >
                        View my work <span aria-hidden="true">↓</span>
                    </a>
                </div>
            </div>

            <!-- ─── Expertise ─────────────────────────────────────── -->
            <div id="expertise" class="mb-16">
                <div class="mb-6 flex items-center gap-4">
                    <h2 class="shrink-0 text-sm font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">Expertise</h2>
                    <div class="h-px flex-1 bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                </div>
                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="card in expertiseCards"
                        :key="card.title"
                        class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm transition-all hover:-translate-y-1 hover:shadow-md dark:border-[#2a2a28] dark:bg-[#111110]/60"
                    >
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <component :is="card.icon" class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <p class="mb-1 font-semibold text-sm">{{ card.title }}</p>
                        <p class="mb-3 text-xs leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ card.description }}</p>
                        <span class="rounded-full border border-[#e3e3e0] px-2 py-0.5 text-xs text-[#706f6c] dark:border-[#2a2a28] dark:text-[#A1A09A]">{{ card.tag }}</span>
                    </div>
                </div>
            </div>

            <!-- ─── Philosophy / My Approach ──────────────────────── -->
            <div class="mb-16">
                <div class="mb-6 flex items-center gap-4">
                    <h2 class="shrink-0 text-sm font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">Philosophy</h2>
                    <div class="h-px flex-1 bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                </div>
                <div class="grid gap-6 grid-cols-1 md:grid-cols-3">
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <p class="mb-2 text-3xl font-bold text-[#e3e3e0] dark:text-[#2a2a28]">01</p>
                        <p class="mb-1 font-semibold">Understand</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Start with the business problem, not the stack. Map the journey, identify the success metric.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <p class="mb-2 text-3xl font-bold text-[#e3e3e0] dark:text-[#2a2a28]">02</p>
                        <p class="mb-1 font-semibold">Architect</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Design for today's complexity with clear seams for tomorrow's growth. Simplicity over cleverness.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <p class="mb-2 text-3xl font-bold text-[#e3e3e0] dark:text-[#2a2a28]">03</p>
                        <p class="mb-1 font-semibold">Deliver</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Observable, tested, deployed with confidence. The kind of code you'd want to inherit.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ─── Principles ─────────────────────────────────────── -->
            <div class="mb-16">
                <div class="mb-6 flex items-center gap-4">
                    <h2 class="shrink-0 text-sm font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">Principles</h2>
                    <div class="h-px flex-1 bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <BarChart2 class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <p class="mb-1 font-semibold">Measure first</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Every optimisation starts with profiling. No guessing, no premature abstractions.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <Shield class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <p class="mb-1 font-semibold">Security by default</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Least-privilege IAM, OWASP reviews, and HIPAA/SOC 2 controls baked in — not bolted on.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#e3e3e0] bg-white/60 p-6 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                            <Rocket class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]" />
                        </div>
                        <p class="mb-1 font-semibold">Ship with confidence</p>
                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Automated pipelines, blue/green deploys, and observability so releases feel routine, not risky.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ─── Technical Q&A ──────────────────────────────────── -->
            <div class="mb-16">
                <div class="mb-6 flex items-center gap-4">
                    <h2 class="shrink-0 text-sm font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">Technical Q&amp;A</h2>
                    <div class="h-px flex-1 bg-[#e3e3e0] dark:bg-[#1f1f1f]"></div>
                </div>
                <p class="mb-8 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    Common questions I get from clients, hiring managers, and fellow engineers — answered honestly.
                </p>

                <div
                    v-for="(group, groupIndex) in faqGroups"
                    :key="group.category"
                    :class="groupIndex > 0 ? 'mt-8' : ''"
                >
                    <p class="mb-3 text-xs font-semibold tracking-widest uppercase text-[#706f6c] dark:text-[#A1A09A]">
                        {{ group.category }}
                    </p>
                    <div class="space-y-3">
                        <div
                            v-for="(qa, itemIndex) in group.items"
                            :key="itemIndex"
                            class="overflow-hidden rounded-xl border border-[#e3e3e0] bg-white/60 backdrop-blur-sm dark:border-[#2a2a28] dark:bg-[#111110]/60"
                        >
                            <button
                                class="flex w-full items-center justify-between px-6 py-4 text-left transition-colors hover:bg-[#f8f8f7] dark:hover:bg-[#1a1a19]"
                                @click="toggleFaq(groupIndex, itemIndex)"
                            >
                                <span class="pr-4 text-sm font-medium leading-snug">{{ qa.question }}</span>
                                <ChevronDown
                                    v-if="!isFaqOpen(groupIndex, itemIndex)"
                                    class="h-4 w-4 flex-shrink-0 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                                <ChevronUp
                                    v-else
                                    class="h-4 w-4 flex-shrink-0 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                            </button>
                            <Transition
                                enter-active-class="transition-all duration-200 ease-out"
                                leave-active-class="transition-all duration-150 ease-in"
                                enter-from-class="opacity-0 max-h-0"
                                enter-to-class="opacity-100 max-h-[500px]"
                                leave-from-class="opacity-100 max-h-[500px]"
                                leave-to-class="opacity-0 max-h-0"
                            >
                                <div v-if="isFaqOpen(groupIndex, itemIndex)" class="overflow-hidden">
                                    <div class="border-t border-[#e3e3e0] px-6 py-4 dark:border-[#2a2a28]">
                                        <p class="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ qa.answer }}
                                        </p>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ─── CTA ───────────────────────────────────────────── -->
            <div class="rounded-2xl border border-[#e3e3e0] bg-[#f8f8f7] p-8 text-center dark:border-[#2a2a28] dark:bg-[#111110]">
                <h2 class="mb-3 text-2xl font-bold tracking-tight">Let's build something together</h2>
                <p class="mb-6 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    Whether you need a senior engineer for a complex project, a technical lead to guide a team, or a second opinion on your architecture — I'm happy to talk.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a
                        :href="contactUrl"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        Get in touch <span aria-hidden="true">→</span>
                    </a>
                    <a
                        href="https://www.linkedin.com/in/jkavuncuoglu/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg border border-[#e3e3e0] bg-[#FDFDFC] px-6 py-3 text-sm font-medium transition-colors hover:bg-[#f4f4f2] dark:border-[#2a2a28] dark:bg-[#0a0a0a] dark:hover:bg-[#1f1f1f]"
                    >
                        Connect on LinkedIn
                    </a>
                </div>
            </div>

        </div>
    </GuestLayout>
</template>
