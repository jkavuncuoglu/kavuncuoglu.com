<script setup lang="ts">
interface TechItem {
    name: string;
    sub: string;
    img?: string;
    compliance?: boolean;
}

defineProps<{ monochrome?: boolean }>();

const stack: TechItem[] = [
    { name: 'Laravel',        sub: 'v12',                img: '/images/brands/laravel.jpeg' },
    { name: 'Vue.js',         sub: 'v3 · Inertia.js',    img: '/images/brands/vue-js.png' },
    { name: 'PHP',            sub: '8.x' },
    { name: 'AWS',            sub: 'Lambda · ECS · S3',   img: '/images/brands/amazon-web-services.png' },
    { name: 'Amazon Connect', sub: 'Streams API · CX',    img: '/images/brands/amazon-connect.png' },
    { name: 'Terraform',      sub: 'IaC',                 img: '/images/brands/terraform.svg' },
    { name: 'Docker',         sub: 'Containers' },
    { name: 'TypeScript',     sub: 'Type Safety' },
    { name: 'GitHub Actions', sub: 'CI/CD · Automation' },
    { name: 'Neuron AI',      sub: 'RAG · Embeddings' },
    { name: 'Ollama',         sub: 'Local LLMs' },
    { name: 'MySQL',          sub: 'PostgreSQL · Redis' },
    { name: 'HIPAA',          sub: 'Healthcare Privacy',  compliance: true },
    { name: 'HITRUST',        sub: 'CSF Framework',       compliance: true },
    { name: 'SOC 2',          sub: 'Type II',             compliance: true },
];
</script>

<template>
    <div class="grid w-full grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5">
        <div
            v-for="item in stack"
            :key="item.name"
            class="flex flex-col items-center gap-3 rounded-xl border border-[#e3e3e0] bg-white p-5 transition-all hover:-translate-y-1 hover:border-[#c9c9c6] dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
        >
            <!-- Logo container — neutral bg so all images render cleanly in light & dark -->
            <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-xl bg-[#f4f4f2] dark:bg-[#1f1f1f]">

                <!-- Compliance badge -->
                <template v-if="item.compliance">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 text-[#1b1b18] dark:text-[#EDEDEC]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L3 7V12C3 16.97 7.16 21.57 12 22C16.84 21.57 21 16.97 21 12V7L12 2Z" fill="currentColor" opacity="0.12"/>
                        <path d="M12 2L3 7V12C3 16.97 7.16 21.57 12 22C16.84 21.57 21 16.97 21 12V7L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <polyline points="8,12.5 10.5,15 16,9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </template>

                <!-- Image-based logos — rendered naturally inside the neutral container -->
                <img
                    v-else-if="item.img"
                    :src="item.img"
                    :alt="item.name"
                    class="h-10 w-10 object-contain"
                />

                <!-- Inline SVG logos -->
                <template v-else>

                    <!-- PHP ── oval pill badge -->
                    <svg v-if="item.name === 'PHP'" viewBox="0 0 100 50" class="h-8 w-14" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="50" cy="25" rx="48" ry="23" fill="#777BB4"/>
                        <text x="50" y="33" text-anchor="middle" fill="white" font-weight="bold" font-size="22" font-family="monospace" letter-spacing="-0.5">php</text>
                    </svg>

                    <!-- Docker ── container stack + whale -->
                    <svg v-else-if="item.name === 'Docker'" viewBox="0 0 80 65" class="h-11 w-14" xmlns="http://www.w3.org/2000/svg">
                        <rect x="30" y="8"  width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="16" y="19" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="30" y="19" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="2"  y="30" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="16" y="30" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="30" y="30" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <rect x="44" y="30" width="12" height="9" rx="1.5" fill="#2496ED"/>
                        <path d="M2 43 C 22 60, 52 57, 70 44" stroke="#2496ED" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        <path d="M68 42 Q78 33 72 25" stroke="#2496ED" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        <circle cx="70" cy="37" r="2.5" fill="#2496ED"/>
                    </svg>

                    <!-- TypeScript ── official blue square + TS -->
                    <svg v-else-if="item.name === 'TypeScript'" viewBox="0 0 100 100" class="h-11 w-11" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="10" fill="#3178C6"/>
                        <text x="50" y="68" text-anchor="middle" fill="white" font-weight="bold" font-size="46" font-family="Arial, sans-serif">TS</text>
                    </svg>

                    <!-- GitHub Actions ── branching workflow (start → 2 parallel jobs → done) -->
                    <svg v-else-if="item.name === 'GitHub Actions'" viewBox="0 0 100 100" class="h-11 w-11 text-[#24292F] dark:text-[#EDEDEC]" xmlns="http://www.w3.org/2000/svg">
                        <!-- Edges -->
                        <line x1="50" y1="22" x2="28"  y2="48" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
                        <line x1="50" y1="22" x2="72"  y2="48" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
                        <line x1="28" y1="62" x2="50"  y2="82" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
                        <line x1="72" y1="62" x2="50"  y2="82" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
                        <!-- Nodes -->
                        <circle cx="50" cy="14" r="9" fill="currentColor"/>
                        <circle cx="28" cy="55" r="9" fill="currentColor"/>
                        <circle cx="72" cy="55" r="9" fill="currentColor"/>
                        <circle cx="50" cy="88" r="9" fill="currentColor"/>
                        <!-- Check marks (always white for contrast) -->
                        <path d="M44.5,14 L48,17.5 L55.5,9.5"  stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22.5,55 L26,58.5 L33.5,50.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M66.5,55 L70,58.5 L77.5,50.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M44.5,88 L48,91.5 L55.5,83.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <!-- Neuron AI ── 3-layer neural network -->
                    <svg v-else-if="item.name === 'Neuron AI'" viewBox="0 0 100 100" class="h-11 w-11" xmlns="http://www.w3.org/2000/svg">
                        <line x1="21" y1="28" x2="43" y2="20" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="28" x2="43" y2="43" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="50" x2="43" y2="20" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="50" x2="43" y2="43" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="50" x2="43" y2="65" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="72" x2="43" y2="43" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="72" x2="43" y2="65" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="21" y1="72" x2="43" y2="80" stroke="#10B981" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="20" x2="79" y2="38" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="43" x2="79" y2="38" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="43" x2="79" y2="63" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="65" x2="79" y2="38" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="65" x2="79" y2="63" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <line x1="57" y1="80" x2="79" y2="63" stroke="#34D399" stroke-width="1.3" opacity="0.5"/>
                        <circle cx="14" cy="28" r="7" fill="#10B981"/>
                        <circle cx="14" cy="50" r="7" fill="#10B981"/>
                        <circle cx="14" cy="72" r="7" fill="#10B981"/>
                        <circle cx="50" cy="20" r="7" fill="#34D399"/>
                        <circle cx="50" cy="43" r="7" fill="#34D399"/>
                        <circle cx="50" cy="65" r="7" fill="#34D399"/>
                        <circle cx="50" cy="80" r="7" fill="#34D399"/>
                        <circle cx="86" cy="38" r="7" fill="#6EE7B7"/>
                        <circle cx="86" cy="63" r="7" fill="#6EE7B7"/>
                    </svg>

                    <!-- Ollama ── minimal llama face -->
                    <svg v-else-if="item.name === 'Ollama'" viewBox="0 0 100 100" class="h-11 w-11" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="50" cy="78" rx="22" ry="13" fill="#6366F1"/>
                        <circle  cx="50" cy="46" r="22" fill="#6366F1"/>
                        <ellipse cx="34" cy="26" rx="5.5" ry="10" fill="#6366F1"/>
                        <ellipse cx="34" cy="26" rx="3"   ry="7"  fill="#818CF8"/>
                        <ellipse cx="66" cy="26" rx="5.5" ry="10" fill="#6366F1"/>
                        <ellipse cx="66" cy="26" rx="3"   ry="7"  fill="#818CF8"/>
                        <ellipse cx="42" cy="42" rx="4.5" ry="5"  fill="white"/>
                        <ellipse cx="58" cy="42" rx="4.5" ry="5"  fill="white"/>
                        <circle  cx="43" cy="43" r="2.5" fill="#1E1B4B"/>
                        <circle  cx="59" cy="43" r="2.5" fill="#1E1B4B"/>
                        <ellipse cx="50" cy="55" rx="9"   ry="6"  fill="#818CF8"/>
                    </svg>

                    <!-- MySQL ── database cylinder -->
                    <svg v-else-if="item.name === 'MySQL'" viewBox="0 0 100 100" class="h-11 w-11" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="50" cy="78" rx="35" ry="12" fill="#2D5F8A"/>
                        <rect x="15" y="27" width="70" height="51" fill="#4479A1"/>
                        <ellipse cx="50" cy="44" rx="35" ry="10" fill="#3B75AA" opacity="0.6"/>
                        <ellipse cx="50" cy="60" rx="35" ry="10" fill="#3B75AA" opacity="0.35"/>
                        <ellipse cx="50" cy="27" rx="35" ry="12" fill="#5B92BE"/>
                        <ellipse cx="44" cy="25" rx="16"  ry="6"  fill="#7AB0D4" opacity="0.4"/>
                    </svg>

                </template>
            </div>

            <!-- Tech name -->
            <span class="text-center text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                {{ item.name }}
            </span>
            <!-- Sub-label -->
            <span v-if="item.sub" class="text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
                {{ item.sub }}
            </span>
        </div>
    </div>
</template>
