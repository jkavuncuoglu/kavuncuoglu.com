<script setup lang="ts">
import { ExternalLink } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';

interface MediumPost {
    title: string;
    url: string;
    date: string;
    thumbnail: string | null;
    excerpt: string;
    tags: string[];
}

defineProps<{
    mediumPosts: MediumPost[];
}>();

const { t } = useI18n();
</script>

<template>
    <section id="blog" class="px-6 py-24">
        <div class="mx-auto max-w-6xl">
            <div class="mb-12 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ t('welcome.blog_title') }}
                </h2>
                <a
                    href="https://medium.com/@jkavuncuoglu"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm text-[#706f6c] transition-colors hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                >
                    {{ t('welcome.blog_view_all') }}
                    <ExternalLink class="h-3.5 w-3.5" />
                </a>
            </div>

            <p
                v-if="!mediumPosts.length"
                class="text-center text-[#706f6c] dark:text-[#A1A09A]"
            >
                {{ t('welcome.blog_empty') }}
            </p>

            <div
                v-else
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <a
                    v-for="post in mediumPosts"
                    :key="post.url"
                    :href="post.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex flex-col overflow-hidden rounded-xl border border-[#e3e3e0] bg-white shadow-sm transition-all hover:-translate-y-1 hover:border-[#c9c9c6] hover:shadow-md dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                >
                    <div
                        class="relative h-40 overflow-hidden bg-gradient-to-br from-green-400 to-teal-600"
                    >
                        <img
                            v-if="post.thumbnail"
                            :src="post.thumbnail"
                            :alt="post.title"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        />
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <p
                            class="mb-2 text-xs text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ post.date }}
                        </p>
                        <h3 class="mb-2 text-base leading-snug font-semibold">
                            {{ post.title }}
                        </h3>
                        <p
                            class="mb-4 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                        >
                            {{ post.excerpt }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tag in post.tags"
                                :key="tag"
                                class="rounded-full bg-[#f4f4f2] px-2.5 py-0.5 text-xs text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</template>
