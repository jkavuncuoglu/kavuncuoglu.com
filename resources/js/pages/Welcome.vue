<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ChevronUp } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import GuestLayout from '@/layouts/GuestLayout.vue';
import HeroSection from './sections/HeroSection.vue';
import AboutSection from './sections/AboutSection.vue';
import SkillsSection from './sections/SkillsSection.vue';
import ExperienceSection from './sections/ExperienceSection.vue';
import ProjectsSection from './sections/ProjectsSection.vue';
import BlogSection from './sections/BlogSection.vue';
import ContactSection from './sections/ContactSection.vue';

interface MediumPost {
    title: string;
    url: string;
    date: string;
    thumbnail: string | null;
    excerpt: string;
    tags: string[];
}

withDefaults(
    defineProps<{
        canRegister: boolean;
        mediumPosts: MediumPost[];
    }>(),
    {
        canRegister: true,
        mediumPosts: () => [],
    },
);

const { t } = useI18n();
const page = usePage();
const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const contactUrl = computed(() => `/${currentLocale.value}/contact`);

// Scroll / visibility
const isVisible = ref(false);
const activeSection = ref('');
const showBackToTop = ref(false);
const atBottom = ref(false);
const pastHero = ref(false);
const heroRef = ref<HTMLElement | null>(null);

const handleScroll = () => {
    const scrollY = window.scrollY;
    showBackToTop.value = scrollY > 400;
    atBottom.value = scrollY + window.innerHeight >= document.documentElement.scrollHeight - 20;
    if (heroRef.value) {
        pastHero.value = scrollY > heroRef.value.offsetHeight - 100;
    }
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const tocItems = computed(() => [
    { id: 'about',      label: t('welcome.about_title') },
    { id: 'skills',     label: t('welcome.skills_title') },
    { id: 'experience', label: t('welcome.experience_title') },
    { id: 'projects',   label: t('welcome.projects_title') },
    { id: 'blog',       label: t('welcome.blog_title') },
    { id: 'contact',    label: t('welcome.contact_title') },
]);

const scrollToSection = (id: string) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
};

let observer: IntersectionObserver | null = null;

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeSection.value = entry.target.id;
                }
            });
        },
        { rootMargin: '-10% 0% -60% 0%', threshold: 0 },
    );

    ['about', 'skills', 'experience', 'projects', 'blog', 'contact'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) observer!.observe(el);
    });

    window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
    observer?.disconnect();
    window.removeEventListener('scroll', handleScroll);
});
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

    <GuestLayout>
        <div class="relative z-[1]">
            <!-- Floating TOC (lg+ only, visible after hero) -->
            <Transition name="toc">
                <aside v-if="pastHero" class="fixed right-6 top-28 z-40 hidden w-40 lg:block">
                    <nav class="py-2">
                        <p class="mb-3 text-right text-xs font-semibold tracking-wider text-[#706f6c] uppercase dark:text-[#A1A09A]">
                            {{ t('welcome.toc_title') }}
                        </p>
                        <ul class="space-y-0.5">
                            <li v-for="item in tocItems" :key="item.id">
                                <button
                                    @click="scrollToSection(item.id)"
                                    :class="[
                                        'w-full rounded-md px-2 py-1.5 text-right text-sm transition-colors',
                                        activeSection === item.id
                                            ? 'font-medium text-[#1b1b18] dark:text-[#EDEDEC]'
                                            : 'text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]',
                                    ]"
                                >
                                    {{ item.label }}
                                </button>
                            </li>
                        </ul>
                    </nav>
                </aside>
            </Transition>

            <div>
                <div ref="heroRef">
                    <HeroSection
                        :is-visible="isVisible"
                        :contact-url="contactUrl"
                    />
                </div>
                <AboutSection />
                <SkillsSection />
                <ExperienceSection />
                <ProjectsSection />
                <BlogSection :medium-posts="mediumPosts" />
                <ContactSection :contact-url="contactUrl" />
            </div>
        </div>

        <!-- Back to top -->
        <Transition name="btt">
            <button
                v-if="showBackToTop"
                @click="scrollToTop"
                :class="[
                    'fixed right-8 z-50 flex h-10 w-10 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC]/90 text-[#706f6c] shadow-md backdrop-blur-sm transition-all duration-300 hover:border-blue-400 hover:text-blue-500 dark:border-[#2a2a2a] dark:bg-[#0a0a0a]/90 dark:text-[#A1A09A] dark:hover:border-blue-500 dark:hover:text-blue-400',
                    atBottom ? 'bottom-32' : 'bottom-8',
                ]"
                aria-label="Back to top"
            >
                <ChevronUp class="h-5 w-5" />
            </button>
        </Transition>
    </GuestLayout>
</template>

<style scoped>
.btt-enter-active,
.btt-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.btt-enter-from,
.btt-leave-to {
    opacity: 0;
    transform: translateY(8px);
}

.toc-enter-active,
.toc-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.toc-enter-from,
.toc-leave-to {
    opacity: 0;
    transform: translateX(10px);
}
</style>
