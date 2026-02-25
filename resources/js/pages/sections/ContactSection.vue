<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Mail, Linkedin } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    contactUrl: string;
}>();

const { t } = useI18n();

const contactForm = useForm({ name: '', email: '', message: '' });
const submitContact = () => {
    contactForm.post(props.contactUrl, { preserveScroll: true });
};
</script>

<template>
    <section id="contact" class="px-6 py-24">
        <div class="mx-auto max-w-4xl">
            <div
                class="rounded-2xl border border-[#e3e3e0] bg-white p-8 shadow-lg dark:border-[#2a2a28] dark:bg-[#161615] md:p-12"
            >
                <h2 class="mb-4 text-center text-3xl font-bold">
                    {{ t('welcome.contact_title') }}
                </h2>
                <p
                    class="mb-12 text-center leading-relaxed text-[#706f6c] dark:text-[#A1A09A]"
                >
                    {{ t('welcome.contact_body') }}
                </p>

                <div class="grid gap-12 md:grid-cols-2">
                    <!-- Inline mini-form -->
                    <div>
                        <!-- Success state -->
                        <div
                            v-if="contactForm.wasSuccessful"
                            class="rounded-xl border border-[#e3e3e0] bg-[#f4f4f2] p-8 text-center dark:border-[#2a2a28] dark:bg-[#1f1f1f]"
                        >
                            <h3 class="mb-2 text-lg font-semibold">
                                {{ t('contact.success_heading') }}
                            </h3>
                            <p
                                class="text-sm text-[#706f6c] dark:text-[#A1A09A]"
                            >
                                {{ t('contact.success_body') }}
                            </p>
                        </div>

                        <!-- Form -->
                        <form
                            v-else
                            @submit.prevent="submitContact"
                            class="space-y-4"
                        >
                            <div>
                                <label
                                    for="contact-name"
                                    class="mb-1.5 block text-sm font-medium"
                                    >{{ t('contact.name') }}</label
                                >
                                <input
                                    id="contact-name"
                                    v-model="contactForm.name"
                                    type="text"
                                    :placeholder="t('contact.name_placeholder')"
                                    required
                                    class="w-full rounded-lg border border-[#e3e3e0] bg-white px-3 py-2 text-sm placeholder:text-[#c9c9c6] focus:border-[#1b1b18] focus:outline-none dark:border-[#2a2a28] dark:bg-[#161615] dark:placeholder:text-[#3E3E3A] dark:focus:border-[#A1A09A]"
                                />
                                <InputError
                                    :message="contactForm.errors.name"
                                    class="mt-1"
                                />
                            </div>
                            <div>
                                <label
                                    for="contact-email"
                                    class="mb-1.5 block text-sm font-medium"
                                    >{{ t('contact.email') }}</label
                                >
                                <input
                                    id="contact-email"
                                    v-model="contactForm.email"
                                    type="email"
                                    :placeholder="t('contact.email_placeholder')"
                                    required
                                    class="w-full rounded-lg border border-[#e3e3e0] bg-white px-3 py-2 text-sm placeholder:text-[#c9c9c6] focus:border-[#1b1b18] focus:outline-none dark:border-[#2a2a28] dark:bg-[#161615] dark:placeholder:text-[#3E3E3A] dark:focus:border-[#A1A09A]"
                                />
                                <InputError
                                    :message="contactForm.errors.email"
                                    class="mt-1"
                                />
                            </div>
                            <div>
                                <label
                                    for="contact-message"
                                    class="mb-1.5 block text-sm font-medium"
                                    >{{ t('contact.message') }}</label
                                >
                                <textarea
                                    id="contact-message"
                                    v-model="contactForm.message"
                                    rows="5"
                                    :placeholder="t('contact.message_placeholder')"
                                    required
                                    class="w-full resize-none rounded-lg border border-[#e3e3e0] bg-white px-3 py-2 text-sm placeholder:text-[#c9c9c6] focus:border-[#1b1b18] focus:outline-none dark:border-[#2a2a28] dark:bg-[#161615] dark:placeholder:text-[#3E3E3A] dark:focus:border-[#A1A09A]"
                                ></textarea>
                                <InputError
                                    :message="contactForm.errors.message"
                                    class="mt-1"
                                />
                            </div>
                            <button
                                type="submit"
                                :disabled="contactForm.processing"
                                class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-6 py-3 font-medium text-white transition-colors hover:bg-[#2d2d2a] disabled:opacity-50 dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
                            >
                                <Mail class="h-4 w-4" />
                                {{ t('contact.send') }}
                            </button>
                        </form>
                    </div>

                    <!-- Secondary contact options -->
                    <div class="flex flex-col justify-center gap-6">
                        <div class="flex flex-col gap-3">
                            <Link
                                :href="contactUrl"
                                class="inline-flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-[#FDFDFC] px-4 py-3 text-sm font-medium text-[#1b1b18] transition-colors hover:border-[#c9c9c6] hover:bg-[#f4f4f2] dark:border-[#2a2a28] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A] dark:hover:bg-[#1f1f1f]"
                            >
                                <Mail
                                    class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                                {{ t('welcome.contact_cta') }}
                            </Link>
                            <a
                                href="https://www.linkedin.com/in/jkavuncuoglu/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-[#FDFDFC] px-4 py-3 text-sm font-medium text-[#1b1b18] transition-colors hover:border-[#c9c9c6] hover:bg-[#f4f4f2] dark:border-[#2a2a28] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A] dark:hover:bg-[#1f1f1f]"
                            >
                                <Linkedin
                                    class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]"
                                />
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
