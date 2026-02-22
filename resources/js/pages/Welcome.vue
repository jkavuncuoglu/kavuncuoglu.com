<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { login } from '@/routes';
import {
    Github,
    Linkedin,
    Mail,
    ExternalLink,
    Code2,
    Server,
    Shield,
    Cloud,
    Terminal,
    Database,
    ChevronDown,
} from 'lucide-vue-next';
import { ref, onMounted, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import TechStackLogos from '@/components/ui/techstack/TechStackLogos.vue';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const { t } = useI18n();
const page = usePage();
const localizedUrls = computed(() => (page.props.localizedUrls as Record<string, string>) ?? {});
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const chatUrl = computed(() => {
    const base = localizedUrls.value[currentLocale.value] ?? `/${currentLocale.value}`;
    return base.replace(/\/$/, '') + '/chat';
});

const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});

const skills = computed(() => [
    {
        category: t('welcome.skill_frontend'),
        icon: Code2,
        items: ['Vue.js', 'React', 'TypeScript', 'Tailwind CSS', 'Inertia.js'],
    },
    {
        category: t('welcome.skill_backend'),
        icon: Server,
        items: ['Laravel', 'Node.js', 'Python', 'PHP', 'REST APIs'],
    },
    {
        category: t('welcome.skill_devops'),
        icon: Cloud,
        items: ['AWS Lambda', 'Docker', 'Kubernetes', 'Terraform', 'CI/CD'],
    },
    {
        category: t('welcome.skill_devsecops'),
        icon: Shield,
        items: ['Security Automation', 'SAST/DAST', 'Compliance', 'Monitoring'],
    },
    {
        category: t('welcome.skill_infrastructure'),
        icon: Database,
        items: ['MySQL', 'PostgreSQL', 'Redis', 'Nginx', 'Linux'],
    },
    {
        category: t('welcome.skill_tools'),
        icon: Terminal,
        items: ['Git', 'GitHub Actions', 'GitLab CI', 'Jenkins', 'Ansible'],
    },
]);

const projects = computed(() => [
    {
        title: t('welcome.project1_title'),
        description: t('welcome.project1_desc'),
        tags: ['AWS', 'Terraform', 'Docker', 'CI/CD'],
    },
    {
        title: t('welcome.project2_title'),
        description: t('welcome.project2_desc'),
        tags: ['Laravel', 'Vue.js', 'MySQL', 'Tailwind'],
    },
    {
        title: t('welcome.project3_title'),
        description: t('welcome.project3_desc'),
        tags: ['DevSecOps', 'Python', 'GitHub Actions', 'Security'],
    },
]);

const scrollToSection = (id: string) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <Head title="Jeremy C Kavuncuoglu - Full Stack Developer & DevOps Engineer">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <meta
            name="description"
            content="Full Stack Developer & DevOps Engineer specializing in Laravel, Vue.js, AWS, and infrastructure automation."
        />
    </Head>

    <div
        class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <!-- Navigation -->
        <header
            class="fixed top-0 right-0 left-0 z-50 border-b border-[#e3e3e0] bg-[#FDFDFC]/80 backdrop-blur-md dark:border-[#1f1f1f] dark:bg-[#0a0a0a]/80"
        >
            <nav class="mx-auto max-w-6xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <a href="#" class="text-lg font-semibold tracking-tight"
                        >JK</a
                    >
                    <div class="flex items-center gap-6">
                        <button
                            @click="scrollToSection('about')"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('welcome.about_title') }}
                        </button>
                        <button
                            @click="scrollToSection('skills')"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('welcome.skills_title') }}
                        </button>
                        <button
                            @click="scrollToSection('projects')"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('welcome.projects_title') }}
                        </button>
                        <button
                            @click="scrollToSection('contact')"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('welcome.contact_title') }}
                        </button>
                        <LanguageSwitcher />
                        <div
                            class="h-4 w-px bg-[#e3e3e0] dark:bg-[#3E3E3A]"
                        ></div>
                        <Link
                            :href="chatUrl"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('nav.chat') }}
                        </Link>
                        <Link
                            v-if="$page.props.auth.user"
                            href="/dashboard"
                            class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                        >
                            {{ t('nav.dashboard') }}
                        </Link>
                        <template v-else>
                            <Link
                                :href="login()"
                                class="text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                            >
                                {{ t('nav.login') }}
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section
            class="relative flex min-h-screen items-center justify-center px-6 pt-20"
        >
            <div
                class="mx-auto max-w-4xl text-center transition-all duration-1000"
                :class="
                    isVisible
                        ? 'translate-y-0 opacity-100'
                        : 'translate-y-8 opacity-0'
                "
            >
                <div class="mb-6">
                    <span
                        class="inline-block rounded-full bg-[#f4f4f2] px-4 py-1.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                    >
                        {{ t('welcome.badge') }}
                    </span>
                </div>
                <h1
                    class="mb-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl"
                >
                    {{ t('welcome.name') }}
                </h1>
                <p
                    class="mb-4 text-xl text-[#706f6c] sm:text-2xl dark:text-[#A1A09A]"
                >
                    {{ t('welcome.title') }}
                </p>
                <p
                    class="mx-auto mb-10 max-w-2xl text-base leading-relaxed text-[#706f6c] sm:text-lg dark:text-[#A1A09A]"
                >
                    {{ t('welcome.hero_body') }}
                </p>
                <p
                    class="mb-4 text-lg text-[#706f6c] sm:text-2xl dark:text-[#A1A09A]"
                >
                    {{ t('welcome.expertise') }}
                </p>
                <TechStackLogos />
                <div class="mb-12 flex items-center justify-center gap-4">
                    <a
                        href="https://github.com/jkavuncuoglu"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#1b1b18] text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        <Github class="h-5 w-5" />
                    </a>
                    <a
                        href="https://www.linkedin.com/in/jkavuncuoglu/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#1b1b18] text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        <Linkedin class="h-5 w-5" />
                    </a>
                    <a
                        href="mailto:hello@kavuncuoglu.com"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#1b1b18] text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        <Mail class="h-5 w-5" />
                    </a>
                </div>
                <button
                    @click="scrollToSection('about')"
                    class="animate-bounce text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                >
                    <ChevronDown class="h-6 w-6" />
                </button>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="px-6 py-24">
            <div class="mx-auto max-w-4xl">
                <h2 class="mb-8 text-3xl font-bold">{{ t('welcome.about_title') }}</h2>
                <div class="grid gap-12 md:grid-cols-2">
                    <div>
                        <p
                            class="mb-6 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ t('welcome.about_body1') }}
                        </p>
                        <p
                            class="leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ t('welcome.about_body2') }}
                        </p>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                            >
                                <Code2
                                    class="h-5 w-5 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                            </div>
                            <div>
                                <h3 class="mb-1 font-medium">
                                    {{ t('welcome.about_feature1_title') }}
                                </h3>
                                <p
                                    class="text-sm text-[#706f6c] dark:text-[#A1A09A]"
                                >
                                    {{ t('welcome.about_feature1_desc') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                            >
                                <Cloud
                                    class="h-5 w-5 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                            </div>
                            <div>
                                <h3 class="mb-1 font-medium">{{ t('welcome.about_feature2_title') }}</h3>
                                <p
                                    class="text-sm text-[#706f6c] dark:text-[#A1A09A]"
                                >
                                    {{ t('welcome.about_feature2_desc') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                            >
                                <Shield
                                    class="h-5 w-5 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                            </div>
                            <div>
                                <h3 class="mb-1 font-medium">{{ t('welcome.about_feature3_title') }}</h3>
                                <p
                                    class="text-sm text-[#706f6c] dark:text-[#A1A09A]"
                                >
                                    {{ t('welcome.about_feature3_desc') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="bg-[#f9f9f8] px-6 py-24 dark:bg-[#0f0f0f]">
            <div class="mx-auto max-w-6xl">
                <h2 class="mb-12 text-center text-3xl font-bold">
                    {{ t('welcome.skills_title') }}
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="skill in skills"
                        :key="skill.category"
                        class="rounded-xl border border-[#e3e3e0] bg-white p-6 transition-colors hover:border-[#c9c9c6] dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                    >
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f]"
                            >
                                <component
                                    :is="skill.icon"
                                    class="h-5 w-5 text-[#1b1b18] dark:text-[#EDEDEC]"
                                />
                            </div>
                            <h3 class="font-semibold">{{ skill.category }}</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="item in skill.items"
                                :key="item"
                                class="rounded-full bg-[#f4f4f2] px-3 py-1 text-sm text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ item }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="px-6 py-24">
            <div class="mx-auto max-w-6xl">
                <h2 class="mb-12 text-center text-3xl font-bold">
                    {{ t('welcome.projects_title') }}
                </h2>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="project in projects"
                        :key="project.title"
                        class="group rounded-xl border border-[#e3e3e0] bg-white p-6 transition-all hover:-translate-y-1 hover:border-[#c9c9c6] dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                    >
                        <div class="mb-4 flex items-start justify-between">
                            <h3 class="text-lg font-semibold">
                                {{ project.title }}
                            </h3>
                            <ExternalLink
                                class="h-4 w-4 text-[#706f6c] opacity-0 transition-opacity group-hover:opacity-100 dark:text-[#A1A09A]"
                            />
                        </div>
                        <p
                            class="mb-4 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ project.description }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tag in project.tags"
                                :key="tag"
                                class="rounded-full bg-[#f4f4f2] px-2.5 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="bg-[#f9f9f8] px-6 py-24 dark:bg-[#0f0f0f]">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="mb-6 text-3xl font-bold">{{ t('welcome.contact_title') }}</h2>
                <p
                    class="mb-8 leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                >
                    {{ t('welcome.contact_body') }}
                </p>
                <a
                    href="mailto:hello@kavuncuoglu.com"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-8 py-3 font-medium text-white transition-colors hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                >
                    <Mail class="h-4 w-4" />
                    {{ t('welcome.contact_cta') }}
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer
            class="border-t border-[#e3e3e0] px-6 py-8 dark:border-[#1f1f1f]"
        >
            <div
                class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 sm:flex-row"
            >
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ t('footer.rights', { year: new Date().getFullYear() }) }}
                </p>
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
                        href="mailto:hello@kavuncuoglu.com"
                        class="text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        <Mail class="h-5 w-5" />
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>
