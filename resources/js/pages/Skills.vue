<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Code2, Server, Shield, Cloud, Terminal, Database, Zap, BarChart3 } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { ref, computed } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import TechStackLogos from '@/components/ui/techstack/TechStackLogos.vue';
import TechLogo from '@/components/ui/techstack/TechLogo.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from '@/components/ui/dialog';

const { t } = useI18n();
const page = usePage();
const contactUrl = computed(() => `/${(page.props.locale as string) ?? 'en'}/contact`);

interface SkillIconItem {
    name: string;
    kind?: string;
    img?: string;
    compliance?: boolean;
}

interface SkillCategory {
    category: string;
    desc: string;
    icon: object;
    items: SkillIconItem[];
}

const activeSkillTab = ref<'skills' | 'tech'>('skills');
const selectedSkill = ref<SkillCategory | null>(null);
const skillDialogOpen = ref(false);

const openSkill = (skill: SkillCategory) => {
    selectedSkill.value = skill;
    skillDialogOpen.value = true;
};

const skills = computed<SkillCategory[]>(() => [
    {
        category: t('welcome.skill_frontend'),
        desc: t('welcome.skill_frontend_desc'),
        icon: Code2,
        items: [
            { name: 'Vue.js 3',     img: '/images/brands/vue-js.png' },
            { name: 'TypeScript',   kind: 'typescript' },
            { name: 'Tailwind CSS', kind: 'tailwind' },
            { name: 'Inertia.js',   kind: 'inertia' },
            { name: 'React',        kind: 'react' },
        ],
    },
    {
        category: t('welcome.skill_backend'),
        desc: t('welcome.skill_backend_desc'),
        icon: Server,
        items: [
            { name: 'Laravel 12',  img: '/images/brands/laravel.jpeg' },
            { name: 'PHP 8.x',     kind: 'php' },
            { name: 'Node.js',     kind: 'nodejs' },
            { name: 'REST APIs',   kind: 'rest' },
            { name: 'WordPress',   kind: 'wordpress' },
        ],
    },
    {
        category: t('welcome.skill_devops'),
        desc: t('welcome.skill_devops_desc'),
        icon: Cloud,
        items: [
            { name: 'AWS',            img: '/images/brands/amazon-web-services.png' },
            { name: 'Amazon Connect', img: '/images/brands/amazon-connect.png' },
            { name: 'Terraform',      img: '/images/brands/terraform.svg' },
            { name: 'Docker',         kind: 'docker' },
            { name: 'GitHub Actions', kind: 'githubactions' },
        ],
    },
    {
        category: t('welcome.skill_devsecops'),
        desc: t('welcome.skill_devsecops_desc'),
        icon: Shield,
        items: [
            { name: 'HIPAA',         compliance: true },
            { name: 'HITRUST',       compliance: true },
            { name: 'SOC 2',         compliance: true },
            { name: 'OWASP / SAST',  kind: 'owasp' },
            { name: 'AWS IAM',       kind: 'iam' },
        ],
    },
    {
        category: t('welcome.skill_infrastructure'),
        desc: t('welcome.skill_infrastructure_desc'),
        icon: Database,
        items: [
            { name: 'MySQL',      kind: 'mysql' },
            { name: 'PostgreSQL', kind: 'postgresql' },
            { name: 'Redis',      kind: 'redis' },
            { name: 'Redshift',   kind: 'redshift' },
            { name: 'Nginx',      kind: 'nginx' },
        ],
    },
    {
        category: t('welcome.skill_tools'),
        desc: t('welcome.skill_tools_desc'),
        icon: Terminal,
        items: [
            { name: 'Git',            kind: 'git' },
            { name: 'GitHub Actions', kind: 'githubactions' },
            { name: 'PHPUnit',        kind: 'phpunit' },
            { name: 'Agile / Scrum',  kind: 'agile' },
            { name: 'Neuron AI',      kind: 'neuronai' },
        ],
    },
    {
        category: t('welcome.skill_python'),
        desc: t('welcome.skill_python_desc'),
        icon: Zap,
        items: [
            { name: 'Python',       kind: 'python' },
            { name: 'AWS Lambda',   kind: 'lambda' },
            { name: 'Bash / Shell', kind: 'bash' },
            { name: 'boto3',        kind: 'python' },
            { name: 'Automation',   kind: 'agile' },
        ],
    },
    {
        category: t('welcome.skill_data'),
        desc: t('welcome.skill_data_desc'),
        icon: BarChart3,
        items: [
            { name: 'Redshift',      kind: 'redshift' },
            { name: 'MySQL',         kind: 'mysql' },
            { name: 'PostgreSQL',    kind: 'postgresql' },
            { name: 'ETL Pipelines', kind: 'codebuild' },
            { name: 'Data Migration', kind: 'agile' },
        ],
    },
]);
</script>

<template>
    <GuestLayout>
        <Head :title="t('skills.page_title')">
            <meta
                name="description"
                content="Explore Jeremy Kavuncuoglu's full skill set: frontend, backend, DevOps, cloud, security, and the technologies behind his work."
            />
        </Head>

        <div class="mx-auto max-w-5xl px-6 py-16 md:py-24">

            <!-- ─── Hero ─────────────────────────────────────────── -->
            <div class="mb-16 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium tracking-widest text-[#706f6c] uppercase dark:border-[#2a2a28] dark:text-[#A1A09A]"
                >
                    {{ t('skills.badge') }}
                </span>
                <h1 class="mb-4 text-4xl font-bold tracking-tight md:text-5xl">
                    {{ t('skills.heading') }}
                </h1>
                <p class="mx-auto max-w-2xl text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('skills.intro') }}
                </p>
            </div>

            <!-- ─── Tab bar ───────────────────────────────────────── -->
            <div class="mb-10 flex justify-center">
                <div class="inline-flex rounded-full bg-[#f4f4f2] p-1 dark:bg-[#1f1f1f]">
                    <button
                        @click="activeSkillTab = 'skills'"
                        :class="[
                            'rounded-full px-5 py-2 text-sm font-medium transition-colors',
                            activeSkillTab === 'skills'
                                ? 'bg-white text-[#1b1b18] shadow-sm dark:bg-[#161615] dark:text-[#EDEDEC]'
                                : 'text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]',
                        ]"
                    >
                        {{ t('welcome.skills_tab_skills') }}
                    </button>
                    <button
                        @click="activeSkillTab = 'tech'"
                        :class="[
                            'rounded-full px-5 py-2 text-sm font-medium transition-colors',
                            activeSkillTab === 'tech'
                                ? 'bg-white text-[#1b1b18] shadow-sm dark:bg-[#161615] dark:text-[#EDEDEC]'
                                : 'text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]',
                        ]"
                    >
                        {{ t('welcome.skills_tab_tech') }}
                    </button>
                </div>
            </div>

            <!-- ─── Tab 1: Skills grid ────────────────────────────── -->
            <div v-show="activeSkillTab === 'skills'" class="grid gap-6 sm:grid-cols-2">
                <div
                    v-for="skill in skills"
                    :key="skill.category"
                    class="cursor-pointer rounded-xl border border-[#e3e3e0] bg-white p-6 shadow-sm transition-all hover:border-[#c9c9c6] hover:shadow-md dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                    @click="openSkill(skill)"
                >
                    <div class="mb-3 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                        >
                            <component
                                :is="skill.icon"
                                class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]"
                            />
                        </div>
                        <h3 class="font-semibold">{{ skill.category }}</h3>
                    </div>
                    <p class="mb-4 text-xs leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ skill.desc }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <div
                            v-for="item in skill.items"
                            :key="item.name"
                            :title="item.name"
                            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                        >
                            <TechLogo
                                :kind="item.kind"
                                :img="item.img"
                                :compliance="item.compliance"
                                :name="item.name"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ─── Tab 2: Tech logos ─────────────────────────────── -->
            <div v-show="activeSkillTab === 'tech'" class="flex justify-center">
                <TechStackLogos />
            </div>

            <!-- ─── CTA strip ─────────────────────────────────────── -->
            <div class="mt-16 rounded-2xl border border-[#e3e3e0] bg-[#f8f8f7] p-8 text-center dark:border-[#2a2a28] dark:bg-[#111110]">
                <h2 class="mb-3 text-2xl font-bold tracking-tight">{{ t('skills.cta_heading') }}</h2>
                <p class="mb-6 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('skills.cta_body') }}
                </p>
                <a
                    :href="contactUrl"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                >
                    {{ t('skills.cta_btn') }} <span aria-hidden="true">→</span>
                </a>
            </div>

        </div>

        <!-- ─── Skill detail dialog ───────────────────────────── -->
        <Dialog v-model:open="skillDialogOpen">
            <DialogContent class="max-w-lg">
                <DialogHeader>
                    <div class="mb-3 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                        >
                            <component
                                :is="selectedSkill?.icon"
                                class="h-6 w-6 text-[#1b1b18] dark:text-[#EDEDEC]"
                            />
                        </div>
                        <DialogTitle class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ selectedSkill?.category }}
                        </DialogTitle>
                    </div>
                    <DialogDescription class="text-left text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        {{ selectedSkill?.desc }}
                    </DialogDescription>
                </DialogHeader>

                <div v-if="selectedSkill?.items?.length" class="mt-2">
                    <p class="mb-3 text-xs font-medium uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]">
                        {{ t('skills.dialog_tech_label') }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <div
                            v-for="item in selectedSkill.items"
                            :key="item.name"
                            class="flex flex-col items-center gap-1.5"
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                            >
                                <TechLogo
                                    :kind="item.kind"
                                    :img="item.img"
                                    :compliance="item.compliance"
                                    :name="item.name"
                                />
                            </div>
                            <span class="max-w-[52px] text-center text-[10px] leading-tight text-[#706f6c] dark:text-[#A1A09A]">
                                {{ item.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </GuestLayout>
</template>
