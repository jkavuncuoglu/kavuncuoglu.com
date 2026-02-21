<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login, register } from '@/routes';
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
import { ref, onMounted } from 'vue';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});

const skills = [
    {
        category: 'Frontend',
        icon: Code2,
        items: ['Vue.js', 'React', 'TypeScript', 'Tailwind CSS', 'Inertia.js'],
    },
    {
        category: 'Backend',
        icon: Server,
        items: ['Laravel', 'Node.js', 'Python', 'PHP', 'REST APIs'],
    },
    {
        category: 'DevOps & Cloud',
        icon: Cloud,
        items: ['AWS Lambda', 'Docker', 'Kubernetes', 'Terraform', 'CI/CD'],
    },
    {
        category: 'DevSecOps',
        icon: Shield,
        items: ['Security Automation', 'SAST/DAST', 'Compliance', 'Monitoring'],
    },
    {
        category: 'Infrastructure',
        icon: Database,
        items: ['MySQL', 'PostgreSQL', 'Redis', 'Nginx', 'Linux'],
    },
    {
        category: 'Tools',
        icon: Terminal,
        items: ['Git', 'GitHub Actions', 'GitLab CI', 'Jenkins', 'Ansible'],
    },
];

const projects = [
    {
        title: 'Cloud Infrastructure Platform',
        description: 'Designed and implemented a scalable cloud infrastructure using AWS services with automated CI/CD pipelines and infrastructure-as-code practices.',
        tags: ['AWS', 'Terraform', 'Docker', 'CI/CD'],
    },
    {
        title: 'Full Stack Web Application',
        description: 'Built a modern web application using Laravel and Vue.js with real-time features, authentication, and responsive design.',
        tags: ['Laravel', 'Vue.js', 'MySQL', 'Tailwind'],
    },
    {
        title: 'Security Automation Pipeline',
        description: 'Created an automated security scanning pipeline integrating SAST, DAST, and dependency checking into the development workflow.',
        tags: ['DevSecOps', 'Python', 'GitHub Actions', 'Security'],
    },
];

const scrollToSection = (id: string) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <Head title="Jeremy C Kavuncuoglu - Full Stack Developer & DevOps Engineer">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <meta name="description" content="Full Stack Developer & DevOps Engineer specializing in Laravel, Vue.js, AWS, and infrastructure automation." />
    </Head>

    <div class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <!-- Navigation -->
        <header class="fixed top-0 left-0 right-0 z-50 backdrop-blur-md bg-[#FDFDFC]/80 dark:bg-[#0a0a0a]/80 border-b border-[#e3e3e0] dark:border-[#1f1f1f]">
            <nav class="mx-auto max-w-6xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <a href="#" class="text-lg font-semibold tracking-tight">JK</a>
                    <div class="flex items-center gap-6">
                        <button @click="scrollToSection('about')" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">
                            About
                        </button>
                        <button @click="scrollToSection('skills')" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">
                            Skills
                        </button>
                        <button @click="scrollToSection('projects')" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">
                            Projects
                        </button>
                        <button @click="scrollToSection('contact')" class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors">
                            Contact
                        </button>
                        <div class="h-4 w-px bg-[#e3e3e0] dark:bg-[#3E3E3A]"></div>
                        <Link
                            v-if="$page.props.auth.user"
                            href="/dashboard"
                            class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="login()"
                                class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                            >
                                Login
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center px-6 pt-20">
            <div
                class="max-w-4xl mx-auto text-center transition-all duration-1000"
                :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            >
                <div class="mb-6">
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-medium bg-[#f4f4f2] text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]">
                        Available for new opportunities
                    </span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight mb-6">
                    Jeremy C Kavuncuoglu
                </h1>
                <p class="text-xl sm:text-2xl text-[#706f6c] dark:text-[#A1A09A] mb-4">
                    Full Stack Developer & DevOps Engineer
                </p>
                <p class="text-base sm:text-lg text-[#706f6c] dark:text-[#A1A09A] max-w-2xl mx-auto mb-10 leading-relaxed">
                    Building scalable applications and automating infrastructure.
                    Specializing in Laravel, Vue.js, AWS, and modern DevSecOps practices.
                </p>
                <div class="flex items-center justify-center gap-4 mb-12">
                    <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#1b1b18] text-white hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white transition-colors"
                    >
                        <Github class="w-5 h-5" />
                    </a>
                    <a
                        href="https://linkedin.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#1b1b18] text-white hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white transition-colors"
                    >
                        <Linkedin class="w-5 h-5" />
                    </a>
                    <a
                        href="mailto:hello@example.com"
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#1b1b18] text-white hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white transition-colors"
                    >
                        <Mail class="w-5 h-5" />
                    </a>
                </div>
                <button
                    @click="scrollToSection('about')"
                    class="animate-bounce text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors"
                >
                    <ChevronDown class="w-6 h-6" />
                </button>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-24 px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold mb-8">About Me</h2>
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed mb-6">
                            I'm a passionate Full Stack Developer and DevOps Engineer with expertise in building
                            modern web applications and designing robust cloud infrastructure. My focus is on
                            creating efficient, scalable, and secure solutions.
                        </p>
                        <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                            With experience across the entire development lifecycle, from writing clean backend
                            code to implementing CI/CD pipelines and managing cloud infrastructure, I bring a
                            holistic approach to software development.
                        </p>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f] flex items-center justify-center">
                                <Code2 class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A]" />
                            </div>
                            <div>
                                <h3 class="font-medium mb-1">Full Stack Development</h3>
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Building end-to-end applications with Laravel, Vue.js, and modern frameworks
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f] flex items-center justify-center">
                                <Cloud class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A]" />
                            </div>
                            <div>
                                <h3 class="font-medium mb-1">Cloud & DevOps</h3>
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Automating infrastructure with AWS, Docker, and Terraform
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f] flex items-center justify-center">
                                <Shield class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A]" />
                            </div>
                            <div>
                                <h3 class="font-medium mb-1">DevSecOps</h3>
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Integrating security into every stage of the development process
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="py-24 px-6 bg-[#f9f9f8] dark:bg-[#0f0f0f]">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold mb-12 text-center">Skills & Technologies</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="skill in skills"
                        :key="skill.category"
                        class="p-6 rounded-xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#2a2a28] hover:border-[#c9c9c6] dark:hover:border-[#3E3E3A] transition-colors"
                    >
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-[#f4f4f2] dark:bg-[#1f1f1f] flex items-center justify-center">
                                <component :is="skill.icon" class="w-5 h-5 text-[#1b1b18] dark:text-[#EDEDEC]" />
                            </div>
                            <h3 class="font-semibold">{{ skill.category }}</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="item in skill.items"
                                :key="item"
                                class="px-3 py-1 text-sm rounded-full bg-[#f4f4f2] text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ item }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-24 px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold mb-12 text-center">Featured Projects</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="project in projects"
                        :key="project.title"
                        class="group p-6 rounded-xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#2a2a28] hover:border-[#c9c9c6] dark:hover:border-[#3E3E3A] transition-all hover:-translate-y-1"
                    >
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="font-semibold text-lg">{{ project.title }}</h3>
                            <ExternalLink class="w-4 h-4 text-[#706f6c] dark:text-[#A1A09A] opacity-0 group-hover:opacity-100 transition-opacity" />
                        </div>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-4 leading-relaxed">
                            {{ project.description }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tag in project.tags"
                                :key="tag"
                                class="px-2.5 py-0.5 text-xs rounded-full bg-[#f4f4f2] text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 px-6 bg-[#f9f9f8] dark:bg-[#0f0f0f]">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Let's Work Together</h2>
                <p class="text-[#706f6c] dark:text-[#A1A09A] mb-8 leading-relaxed">
                    I'm always interested in new opportunities and collaborations.
                    Whether you have a project in mind or just want to connect, feel free to reach out.
                </p>
                <a
                    href="mailto:hello@example.com"
                    class="inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-[#1b1b18] text-white hover:bg-[#2d2d2a] dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white transition-colors font-medium"
                >
                    <Mail class="w-4 h-4" />
                    Get in Touch
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-8 px-6 border-t border-[#e3e3e0] dark:border-[#1f1f1f]">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    &copy; {{ new Date().getFullYear() }} Jeremy C Kavuncuoglu. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Github class="w-5 h-5" />
                    </a>
                    <a
                        href="https://linkedin.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Linkedin class="w-5 h-5" />
                    </a>
                    <a
                        href="mailto:hello@example.com"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] transition-colors"
                    >
                        <Mail class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>
