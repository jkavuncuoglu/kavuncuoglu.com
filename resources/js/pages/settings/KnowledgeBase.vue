<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Badge } from '@/components/ui/badge';
import { type BreadcrumbItem } from '@/types';

type Document = {
    id: number;
    title: string;
    type: string;
    source: string | null;
    chunk_index: number;
    created_at: string;
};

type PaginatedDocuments = {
    data: Document[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: { url: string | null; label: string; active: boolean }[];
};

const props = defineProps<{
    documents: PaginatedDocuments;
    stats: Record<string, number>;
    documentTypes: string[];
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    { title: 'Knowledge Base', href: '/settings/knowledge-base' },
];

// Tabs
const activeTab = ref<'manual' | 'upload'>('manual');

// Manual entry form
const manualForm = useForm({
    title: '',
    type: '',
    content: '',
    source: '',
});

function submitManual() {
    manualForm.post('/settings/knowledge-base', {
        onSuccess: () => manualForm.reset(),
    });
}

// File upload form
const uploadForm = useForm({
    file: null as File | null,
    title: '',
    type: '',
    source: '',
});

const selectedFile = ref<File | null>(null);

function onFileChange(e: Event) {
    const input = e.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        selectedFile.value = input.files[0];
        uploadForm.file = input.files[0];
        if (!uploadForm.title) {
            uploadForm.title = input.files[0].name.replace(/\.[^/.]+$/, '');
        }
    }
}

function submitUpload() {
    uploadForm.post('/settings/knowledge-base/upload', {
        forceFormData: true,
        onSuccess: () => {
            uploadForm.reset();
            selectedFile.value = null;
        },
    });
}

function formatFileSize(bytes: number): string {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

// Delete
const deleteDialogOpen = ref(false);
const documentToDelete = ref<Document | null>(null);

function confirmDelete(doc: Document) {
    documentToDelete.value = doc;
    deleteDialogOpen.value = true;
}

function performDelete() {
    if (!documentToDelete.value) return;
    router.delete(`/settings/knowledge-base/${documentToDelete.value.id}`, {
        onSuccess: () => {
            deleteDialogOpen.value = false;
            documentToDelete.value = null;
        },
    });
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Knowledge Base" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading
                    variant="small"
                    title="Knowledge Base"
                    description="Manage documents used by the AI chat assistant"
                />

                <!-- Stats -->
                <div class="flex flex-wrap gap-2">
                    <Badge
                        v-for="(count, type) in stats"
                        :key="type"
                        variant="secondary"
                    >
                        {{ type }}: {{ count }}
                    </Badge>
                    <Badge v-if="Object.keys(stats).length === 0" variant="outline">
                        No documents yet
                    </Badge>
                </div>

                <!-- Tabs -->
                <div class="border-b border-border">
                    <nav class="-mb-px flex space-x-6">
                        <button
                            type="button"
                            :class="[
                                'pb-3 text-sm font-medium border-b-2 transition-colors',
                                activeTab === 'manual'
                                    ? 'border-primary text-foreground'
                                    : 'border-transparent text-muted-foreground hover:text-foreground',
                            ]"
                            @click="activeTab = 'manual'"
                        >
                            Add Entry
                        </button>
                        <button
                            type="button"
                            :class="[
                                'pb-3 text-sm font-medium border-b-2 transition-colors',
                                activeTab === 'upload'
                                    ? 'border-primary text-foreground'
                                    : 'border-transparent text-muted-foreground hover:text-foreground',
                            ]"
                            @click="activeTab = 'upload'"
                        >
                            Import File
                        </button>
                    </nav>
                </div>

                <!-- Manual Entry Form -->
                <form v-if="activeTab === 'manual'" class="space-y-4" @submit.prevent="submitManual">
                    <div class="grid gap-2">
                        <Label for="manual-title">Title</Label>
                        <Input
                            id="manual-title"
                            v-model="manualForm.title"
                            placeholder="Document title"
                            required
                        />
                        <InputError :message="manualForm.errors.title" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="manual-type">Type</Label>
                        <select
                            id="manual-type"
                            v-model="manualForm.type"
                            required
                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                        >
                            <option value="" disabled>Select a type</option>
                            <option v-for="t in documentTypes" :key="t" :value="t">
                                {{ t.charAt(0).toUpperCase() + t.slice(1) }}
                            </option>
                        </select>
                        <InputError :message="manualForm.errors.type" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="manual-source">Source <span class="text-muted-foreground">(optional)</span></Label>
                        <Input
                            id="manual-source"
                            v-model="manualForm.source"
                            placeholder="e.g. LinkedIn, Resume, etc."
                        />
                        <InputError :message="manualForm.errors.source" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="manual-content">Content</Label>
                        <textarea
                            id="manual-content"
                            v-model="manualForm.content"
                            rows="8"
                            required
                            placeholder="Enter document content..."
                            class="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring resize-y"
                        />
                        <InputError :message="manualForm.errors.content" />
                    </div>

                    <Button type="submit" :disabled="manualForm.processing">
                        {{ manualForm.processing ? 'Saving...' : 'Add Document' }}
                    </Button>
                </form>

                <!-- File Upload Form -->
                <form v-if="activeTab === 'upload'" class="space-y-4" @submit.prevent="submitUpload">
                    <div class="grid gap-2">
                        <Label for="upload-file">File</Label>
                        <div class="flex flex-col gap-2">
                            <Input
                                id="upload-file"
                                type="file"
                                accept=".md,.txt,.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg"
                                @change="onFileChange"
                                required
                            />
                            <p v-if="selectedFile" class="text-sm text-muted-foreground">
                                {{ selectedFile.name }} ({{ formatFileSize(selectedFile.size) }})
                            </p>
                        </div>
                        <InputError :message="uploadForm.errors.file" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="upload-title">Title</Label>
                        <Input
                            id="upload-title"
                            v-model="uploadForm.title"
                            placeholder="Document title"
                            required
                        />
                        <InputError :message="uploadForm.errors.title" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="upload-type">Type</Label>
                        <select
                            id="upload-type"
                            v-model="uploadForm.type"
                            required
                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                        >
                            <option value="" disabled>Select a type</option>
                            <option v-for="t in documentTypes" :key="t" :value="t">
                                {{ t.charAt(0).toUpperCase() + t.slice(1) }}
                            </option>
                        </select>
                        <InputError :message="uploadForm.errors.type" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="upload-source">Source <span class="text-muted-foreground">(optional)</span></Label>
                        <Input
                            id="upload-source"
                            v-model="uploadForm.source"
                            placeholder="e.g. LinkedIn, Resume, etc."
                        />
                        <InputError :message="uploadForm.errors.source" />
                    </div>

                    <Button type="submit" :disabled="uploadForm.processing || !selectedFile">
                        {{ uploadForm.processing ? 'Importing...' : 'Import File' }}
                    </Button>
                </form>

                <!-- Document List -->
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold">
                        Documents
                        <span class="text-muted-foreground font-normal">({{ documents.total }} total)</span>
                    </h3>

                    <div v-if="documents.data.length === 0" class="text-sm text-muted-foreground py-4">
                        No documents in the knowledge base yet.
                    </div>

                    <div v-else class="rounded-md border overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-muted/50">
                                <tr>
                                    <th class="text-left px-4 py-2 font-medium">Title</th>
                                    <th class="text-left px-4 py-2 font-medium">Type</th>
                                    <th class="text-left px-4 py-2 font-medium hidden sm:table-cell">Source</th>
                                    <th class="text-left px-4 py-2 font-medium hidden md:table-cell">Chunk #</th>
                                    <th class="text-left px-4 py-2 font-medium hidden lg:table-cell">Created</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                <tr v-for="doc in documents.data" :key="doc.id" class="hover:bg-muted/30">
                                    <td class="px-4 py-2 max-w-[180px] truncate">{{ doc.title }}</td>
                                    <td class="px-4 py-2">
                                        <Badge variant="secondary">{{ doc.type }}</Badge>
                                    </td>
                                    <td class="px-4 py-2 text-muted-foreground hidden sm:table-cell">
                                        {{ doc.source ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-muted-foreground hidden md:table-cell">
                                        {{ doc.chunk_index }}
                                    </td>
                                    <td class="px-4 py-2 text-muted-foreground hidden lg:table-cell whitespace-nowrap">
                                        {{ doc.created_at.slice(0, 10) }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="text-destructive hover:text-destructive hover:bg-destructive/10"
                                            @click="confirmDelete(doc)"
                                        >
                                            Delete
                                        </Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="documents.last_page > 1" class="flex items-center gap-1 pt-2">
                        <template v-for="link in documents.links" :key="link.label">
                            <Button
                                v-if="link.url"
                                variant="outline"
                                size="sm"
                                :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': link.active }"
                                @click="router.get(link.url)"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-2 py-1 text-sm text-muted-foreground"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>

    <!-- Delete Confirmation Dialog -->
    <Dialog v-model:open="deleteDialogOpen">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Delete Document</DialogTitle>
                <DialogDescription>
                    Are you sure you want to delete
                    <strong>{{ documentToDelete?.title }}</strong>?
                    This action cannot be undone.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="outline" @click="deleteDialogOpen = false">Cancel</Button>
                <Button variant="destructive" @click="performDelete">Delete</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
