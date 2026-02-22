<script setup lang="ts">
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { SendHorizontal } from 'lucide-vue-next';

const { t } = useI18n();

type Props = {
    disabled?: boolean;
    placeholder?: string;
};

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
    placeholder: undefined,
});

const resolvedPlaceholder = computed(() => props.placeholder ?? t('chat.placeholder'));

const emit = defineEmits<{
    (e: 'submit', message: string): void;
}>();

const message = ref('');

function handleSubmit() {
    const trimmed = message.value.trim();
    if (trimmed && !props.disabled) {
        emit('submit', trimmed);
        message.value = '';
    }
}

function handleKeydown(event: KeyboardEvent) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        handleSubmit();
    }
}
</script>

<template>
    <div class="border-t bg-background p-4">
        <form @submit.prevent="handleSubmit" class="flex gap-2">
            <textarea
                v-model="message"
                :placeholder="resolvedPlaceholder"
                :disabled="disabled"
                @keydown="handleKeydown"
                rows="1"
                :class="
                    cn(
                        'border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex-1 resize-none rounded-lg border px-4 py-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
                    )
                "
            />
            <Button
                type="submit"
                :disabled="disabled || !message.trim()"
                size="icon"
                class="h-[46px] w-[46px] shrink-0"
            >
                <SendHorizontal class="h-5 w-5" />
            </Button>
        </form>
    </div>
</template>
