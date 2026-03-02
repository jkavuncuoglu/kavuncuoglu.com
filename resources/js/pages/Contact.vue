<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Mail, Github, Linkedin, Send, Clock, CheckCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import GuestLayout from '@/layouts/GuestLayout.vue';

const { t } = useI18n();
const page = usePage();

const success = computed(() => page.props.flash?.success === true);

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const currentLocale = computed(() => (page.props.locale as string) ?? 'en');
const contactUrl = computed(() => `/${currentLocale.value}/contact`);

const submit = () => {
    form.post(contactUrl.value, { preserveScroll: true });
};
</script>

<template>
    <GuestLayout>
        <Head :title="t('contact.page_title')" />

        <!-- relative z-10 sits above the circuit background SVG (which has no z-index) -->
        <div class="relative z-10 min-h-[calc(100vh-7rem)] bg-[#FDFDFC] dark:bg-[#0a0a0a]">
            <div class="mx-auto max-w-6xl px-6 py-16">

                <!-- ── Success state ───────────────────────────────────── -->
                <div
                    v-if="success"
                    class="mx-auto max-w-md rounded-2xl border border-[#e3e3e0] bg-white p-12 text-center shadow-sm dark:border-[#2a2a28] dark:bg-[#161615]"
                >
                    <div class="mb-5 flex justify-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                            <CheckCircle class="h-8 w-8 text-emerald-600 dark:text-emerald-400" />
                        </div>
                    </div>
                    <h1 class="mb-3 text-2xl font-bold">{{ t('contact.success_heading') }}</h1>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">{{ t('contact.success_body') }}</p>
                </div>

                <!-- ── Two-column layout ───────────────────────────────── -->
                <div v-else class="grid gap-12 lg:grid-cols-[1fr_1.7fr] lg:items-start">

                    <!-- Left: info panel -->
                    <div class="flex flex-col gap-6 lg:sticky lg:top-36">

                        <!-- Heading -->
                        <div>
                            <span class="mb-4 inline-block rounded-full bg-[#f4f4f2] px-4 py-1.5 text-xs font-medium text-[#706f6c] dark:bg-[#1f1f1f] dark:text-[#A1A09A]">
                                {{ t('contact.open_to_opportunities') }}
                            </span>
                            <h1 class="mb-4 text-4xl font-bold tracking-tight">
                                {{ t('contact.heading') }}
                            </h1>
                            <p class="text-base leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                                {{ t('contact.description') }}
                            </p>
                        </div>

                        <!-- Contact links card -->
                        <div class="rounded-2xl border border-[#e3e3e0] bg-white p-6 dark:border-[#2a2a28] dark:bg-[#161615]">
                            <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]">
                                {{ t('contact.connect_with_me') }}
                            </p>
                            <div class="space-y-3">
                                <a
                                    href="https://www.linkedin.com/in/jkavuncuoglu/"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-3 rounded-lg p-2 text-sm text-[#1b1b18] transition-colors hover:bg-[#f4f4f2] dark:text-[#EDEDEC] dark:hover:bg-[#1f1f1f]"
                                >
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#2a2a28]">
                                        <Linkedin class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]" />
                                    </div>
                                    <div>
                                        <p class="font-medium">LinkedIn</p>
                                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">linkedin.com/in/jkavuncuoglu</p>
                                    </div>
                                </a>

                                <a
                                    href="https://github.com/jkavuncuoglu"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-3 rounded-lg p-2 text-sm text-[#1b1b18] transition-colors hover:bg-[#f4f4f2] dark:text-[#EDEDEC] dark:hover:bg-[#1f1f1f]"
                                >
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#2a2a28]">
                                        <Github class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]" />
                                    </div>
                                    <div>
                                        <p class="font-medium">GitHub</p>
                                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">github.com/jkavuncuoglu</p>
                                    </div>
                                </a>

                                <a
                                    href="https://medium.com/@jkavuncuoglu"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-3 rounded-lg p-2 text-sm text-[#1b1b18] transition-colors hover:bg-[#f4f4f2] dark:text-[#EDEDEC] dark:hover:bg-[#1f1f1f]"
                                >
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#f4f4f2] dark:bg-[#2a2a28]">
                                        <svg class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zm7.42 0c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.38-2.88-3.38-6.42s1.51-6.42 3.38-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Medium</p>
                                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">medium.com/@jkavuncuoglu</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Response time -->
                        <div class="flex items-center gap-3 rounded-2xl border border-[#e3e3e0] bg-white p-4 dark:border-[#2a2a28] dark:bg-[#161615]">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                                <Clock class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ t('contact.response_time_label') }}</p>
                                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ t('contact.response_time_value') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: form card -->
                    <div class="rounded-2xl border border-[#e3e3e0] bg-white p-8 shadow-sm dark:border-[#2a2a28] dark:bg-[#161615] lg:p-10">
                        <div class="mb-8 flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f4f4f2] dark:bg-[#2a2a28]">
                                <Mail class="h-5 w-5 text-[#706f6c] dark:text-[#A1A09A]" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold">{{ t('contact.send_message_heading') }}</h2>
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ t('contact.required_fields_note') }}</p>
                            </div>
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <!-- Name + Email row -->
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="name">{{ t('contact.name') }} *</Label>
                                    <Input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        :placeholder="t('contact.name_placeholder')"
                                        required
                                        autocomplete="name"
                                    />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="email">{{ t('contact.email') }} *</Label>
                                    <Input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        :placeholder="t('contact.email_placeholder')"
                                        required
                                        autocomplete="email"
                                    />
                                    <InputError :message="form.errors.email" />
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="grid gap-2">
                                <Label for="subject">
                                    {{ t('contact.subject') }}
                                    <span class="ml-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">({{ t('contact.subject_placeholder') }})</span>
                                </Label>
                                <Input
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    :placeholder="t('contact.subject_input_placeholder')"
                                />
                                <InputError :message="form.errors.subject" />
                            </div>

                            <!-- Message -->
                            <div class="grid gap-2">
                                <Label for="message">{{ t('contact.message') }} *</Label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="7"
                                    :placeholder="t('contact.message_placeholder')"
                                    required
                                    class="flex w-full resize-none rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                                ></textarea>
                                <InputError :message="form.errors.message" />
                            </div>

                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full gap-2"
                            >
                                <Send class="h-4 w-4" />
                                {{ form.processing ? t('contact.sending') : t('contact.send') }}
                            </Button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </GuestLayout>
</template>
