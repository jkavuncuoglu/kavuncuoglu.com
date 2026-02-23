<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
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
    form.post(contactUrl.value, {
        preserveScroll: true,
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="t('contact.page_title')" />

        <div class="mx-auto max-w-2xl px-6 py-16">
            <!-- Success state -->
            <div
                v-if="success"
                class="rounded-xl border border-[#e3e3e0] bg-white p-10 text-center dark:border-[#2a2a28] dark:bg-[#161615]"
            >
                <h1 class="mb-3 text-2xl font-bold">{{ t('contact.success_heading') }}</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A]">{{ t('contact.success_body') }}</p>
            </div>

            <!-- Form -->
            <template v-else>
                <h1 class="mb-2 text-3xl font-bold">{{ t('contact.heading') }}</h1>
                <p class="mb-10 text-[#706f6c] dark:text-[#A1A09A]">{{ t('contact.description') }}</p>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Name -->
                    <div class="grid gap-2">
                        <Label for="name">{{ t('contact.name') }}</Label>
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

                    <!-- Email -->
                    <div class="grid gap-2">
                        <Label for="email">{{ t('contact.email') }}</Label>
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

                    <!-- Subject (optional) -->
                    <div class="grid gap-2">
                        <Label for="subject">
                            {{ t('contact.subject') }}
                            <span class="ml-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">({{ t('contact.subject_placeholder') }})</span>
                        </Label>
                        <Input
                            id="subject"
                            v-model="form.subject"
                            type="text"
                        />
                        <InputError :message="form.errors.subject" />
                    </div>

                    <!-- Message -->
                    <div class="grid gap-2">
                        <Label for="message">{{ t('contact.message') }}</Label>
                        <textarea
                            id="message"
                            v-model="form.message"
                            rows="6"
                            :placeholder="t('contact.message_placeholder')"
                            required
                            class="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 resize-none"
                        ></textarea>
                        <InputError :message="form.errors.message" />
                    </div>

                    <Button type="submit" :disabled="form.processing">
                        {{ t('contact.send') }}
                    </Button>
                </form>
            </template>
        </div>
    </GuestLayout>
</template>
