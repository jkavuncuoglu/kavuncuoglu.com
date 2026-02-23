<script setup lang="ts">
defineProps<{
    kind?:       string;
    img?:        string;
    compliance?: boolean;
    name?:       string;
}>();
</script>

<!--
    Renders one technology logo/icon.
    Sizes itself to ~80 % of the parent flex container so the parent
    controls the overall tile dimensions.
-->
<template>

    <!-- ── Compliance shield ── -->
    <template v-if="compliance">
        <svg viewBox="0 0 24 24" class="h-4/5 w-4/5 text-[#1b1b18] dark:text-[#EDEDEC]" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 7V12C3 16.97 7.16 21.57 12 22C16.84 21.57 21 16.97 21 12V7L12 2Z" fill="currentColor" opacity="0.12"/>
            <path d="M12 2L3 7V12C3 16.97 7.16 21.57 12 22C16.84 21.57 21 16.97 21 12V7L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            <polyline points="8,12.5 10.5,15 16,9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg>
    </template>

    <!-- ── Image-based logo ── -->
    <img v-else-if="img" :src="img" :alt="name" class="h-4/5 w-4/5 object-contain" />

    <!-- ── Inline SVG logos ── -->
    <template v-else>

        <!-- TypeScript -->
        <svg v-if="kind === 'typescript'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <rect width="100" height="100" rx="10" fill="#3178C6"/>
            <text x="50" y="68" text-anchor="middle" fill="white" font-weight="bold" font-size="46" font-family="Arial, sans-serif">TS</text>
        </svg>

        <!-- Tailwind CSS -->
        <svg v-else-if="kind === 'tailwind'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <path d="M25 38 C32 22 43 22 50 38 C57 54 68 54 75 38" fill="none" stroke="#06B6D4" stroke-width="11" stroke-linecap="round"/>
            <path d="M10 62 C17 46 28 46 35 62 C42 78 53 78 60 62" fill="none" stroke="#22D3EE" stroke-width="11" stroke-linecap="round"/>
        </svg>

        <!-- Inertia.js -->
        <svg v-else-if="kind === 'inertia'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <rect width="100" height="100" rx="14" fill="#9553E9"/>
            <polygon points="28,25 28,75 72,50" fill="white" opacity="0.95"/>
        </svg>

        <!-- React -->
        <svg v-else-if="kind === 'react'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="7" fill="#61DAFB"/>
            <ellipse cx="50" cy="50" rx="46" ry="17" fill="none" stroke="#61DAFB" stroke-width="3"/>
            <ellipse cx="50" cy="50" rx="46" ry="17" fill="none" stroke="#61DAFB" stroke-width="3" transform="rotate(60 50 50)"/>
            <ellipse cx="50" cy="50" rx="46" ry="17" fill="none" stroke="#61DAFB" stroke-width="3" transform="rotate(120 50 50)"/>
        </svg>

        <!-- PHP -->
        <svg v-else-if="kind === 'php'" viewBox="0 0 100 50" class="h-2/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="50" cy="25" rx="48" ry="23" fill="#777BB4"/>
            <text x="50" y="33" text-anchor="middle" fill="white" font-weight="bold" font-size="22" font-family="monospace" letter-spacing="-0.5">php</text>
        </svg>

        <!-- Node.js -->
        <svg v-else-if="kind === 'nodejs'" viewBox="0 0 100 115" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <polygon points="50,5 95,30 95,85 50,110 5,85 5,30" fill="#339933"/>
            <text x="50" y="62" text-anchor="middle" fill="white" font-weight="bold" font-size="18" font-family="Arial, sans-serif">Node</text>
            <text x="50" y="80" text-anchor="middle" fill="white" font-weight="bold" font-size="11" font-family="Arial, sans-serif" opacity="0.85">.js</text>
        </svg>

        <!-- WordPress -->
        <svg v-else-if="kind === 'wordpress'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="48" fill="#21759B"/>
            <text x="50" y="68" text-anchor="middle" fill="white" font-weight="bold" font-size="52" font-family="Georgia, serif">W</text>
        </svg>

        <!-- REST APIs -->
        <svg v-else-if="kind === 'rest'" viewBox="0 0 100 100" class="h-4/5 w-4/5 text-[#1b1b18] dark:text-[#EDEDEC]" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 30 Q10 30 10 42 Q10 50 16 50 Q10 50 10 58 Q10 70 20 70" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/>
            <path d="M80 30 Q90 30 90 42 Q90 50 84 50 Q90 50 90 58 Q90 70 80 70" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/>
            <text x="50" y="46" text-anchor="middle" fill="currentColor" font-weight="bold" font-size="19" font-family="monospace">API</text>
            <text x="50" y="66" text-anchor="middle" fill="currentColor" font-size="14" font-family="monospace" opacity="0.65">REST</text>
        </svg>

        <!-- Docker -->
        <svg v-else-if="kind === 'docker'" viewBox="0 0 80 65" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
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

        <!-- GitHub Actions -->
        <svg v-else-if="kind === 'githubactions'" viewBox="0 0 100 100" class="h-4/5 w-4/5 text-[#24292F] dark:text-[#EDEDEC]" xmlns="http://www.w3.org/2000/svg">
            <line x1="50" y1="22" x2="28" y2="48" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
            <line x1="50" y1="22" x2="72" y2="48" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
            <line x1="28" y1="62" x2="50" y2="82" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
            <line x1="72" y1="62" x2="50" y2="82" stroke="currentColor" stroke-width="2.2" opacity="0.4"/>
            <circle cx="50" cy="14" r="9" fill="currentColor"/>
            <circle cx="28" cy="55" r="9" fill="currentColor"/>
            <circle cx="72" cy="55" r="9" fill="currentColor"/>
            <circle cx="50" cy="88" r="9" fill="currentColor"/>
            <path d="M44.5,14 L48,17.5 L55.5,9.5"  stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.5,55 L26,58.5 L33.5,50.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M66.5,55 L70,58.5 L77.5,50.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M44.5,88 L48,91.5 L55.5,83.5" stroke="white" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <!-- Neuron AI -->
        <svg v-else-if="kind === 'neuronai'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
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

        <!-- Ollama -->
        <svg v-else-if="kind === 'ollama'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
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

        <!-- MySQL -->
        <svg v-else-if="kind === 'mysql'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="50" cy="78" rx="35" ry="12" fill="#2D5F8A"/>
            <rect x="15" y="27" width="70" height="51" fill="#4479A1"/>
            <ellipse cx="50" cy="44" rx="35" ry="10" fill="#3B75AA" opacity="0.6"/>
            <ellipse cx="50" cy="60" rx="35" ry="10" fill="#3B75AA" opacity="0.35"/>
            <ellipse cx="50" cy="27" rx="35" ry="12" fill="#5B92BE"/>
            <ellipse cx="44" cy="25" rx="16" ry="6" fill="#7AB0D4" opacity="0.4"/>
        </svg>

        <!-- PostgreSQL -->
        <svg v-else-if="kind === 'postgresql'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="50" cy="78" rx="35" ry="12" fill="#264878"/>
            <rect x="15" y="27" width="70" height="51" fill="#336791"/>
            <ellipse cx="50" cy="44" rx="35" ry="10" fill="#3D7BAD" opacity="0.6"/>
            <ellipse cx="50" cy="60" rx="35" ry="10" fill="#3D7BAD" opacity="0.35"/>
            <ellipse cx="50" cy="27" rx="35" ry="12" fill="#4D8EC0"/>
            <path d="M78 18 Q90 12 88 26" fill="none" stroke="#4D8EC0" stroke-width="4" stroke-linecap="round"/>
        </svg>

        <!-- Redis -->
        <svg v-else-if="kind === 'redis'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="50" cy="72" rx="38" ry="13" fill="#A41E11"/>
            <rect x="12" y="44" width="76" height="28" fill="#DC382D"/>
            <ellipse cx="50" cy="56" rx="38" ry="13" fill="#A41E11" opacity="0.6"/>
            <ellipse cx="50" cy="44" rx="38" ry="13" fill="#DC382D"/>
            <ellipse cx="50" cy="44" rx="38" ry="13" fill="#F44"/>
            <ellipse cx="42" cy="41" rx="16" ry="5" fill="white" opacity="0.18"/>
        </svg>

        <!-- Redshift -->
        <svg v-else-if="kind === 'redshift'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <polygon points="50,8 88,30 88,70 50,92 12,70 12,30" fill="#8C4FFF" opacity="0.85"/>
            <polygon points="50,8 88,30 50,52 12,30" fill="#A066FF" opacity="0.9"/>
            <line x1="50" y1="8"  x2="50" y2="52" stroke="white" stroke-width="2" opacity="0.4"/>
            <line x1="12" y1="30" x2="88" y2="30" stroke="white" stroke-width="2" opacity="0.2"/>
            <circle cx="50" cy="52" r="5" fill="white" opacity="0.8"/>
        </svg>

        <!-- Nginx -->
        <svg v-else-if="kind === 'nginx'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <polygon points="50,5 93,75 7,75" fill="#009639" opacity="0.9"/>
            <text x="50" y="68" text-anchor="middle" fill="white" font-weight="bold" font-size="28" font-family="Arial, sans-serif">N</text>
        </svg>

        <!-- OWASP -->
        <svg v-else-if="kind === 'owasp'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 5 L85 22 L85 55 C85 74 68 90 50 95 C32 90 15 74 15 55 L15 22 Z" fill="#E02020" opacity="0.15"/>
            <path d="M50 5 L85 22 L85 55 C85 74 68 90 50 95 C32 90 15 74 15 55 L15 22 Z" fill="none" stroke="#E02020" stroke-width="3" stroke-linejoin="round"/>
            <circle cx="50" cy="44" r="10" fill="none" stroke="#E02020" stroke-width="3"/>
            <line x1="50" y1="54" x2="50" y2="70" stroke="#E02020" stroke-width="3" stroke-linecap="round"/>
            <circle cx="50" cy="77" r="3.5" fill="#E02020"/>
        </svg>

        <!-- AWS IAM -->
        <svg v-else-if="kind === 'iam'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <rect x="28" y="44" width="44" height="36" rx="5" fill="#FF9900" opacity="0.9"/>
            <path d="M34 44 L34 34 C34 22 66 22 66 34 L66 44" fill="none" stroke="#FF9900" stroke-width="5" stroke-linecap="round"/>
            <circle cx="50" cy="59" r="6" fill="white"/>
            <rect x="47" y="62" width="6" height="10" rx="2" fill="white"/>
        </svg>

        <!-- Git -->
        <svg v-else-if="kind === 'git'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <rect x="14" y="14" width="72" height="72" rx="12" fill="#F05032" transform="rotate(45 50 50)"/>
            <circle cx="50" cy="32" r="7" fill="white"/>
            <circle cx="32" cy="68" r="7" fill="white"/>
            <circle cx="68" cy="68" r="7" fill="white"/>
            <line x1="50" y1="39" x2="50" y2="55" stroke="white" stroke-width="4" stroke-linecap="round"/>
            <path d="M50 55 Q50 68 32 68" fill="none" stroke="white" stroke-width="4" stroke-linecap="round"/>
            <path d="M50 55 Q50 68 68 68" fill="none" stroke="white" stroke-width="4" stroke-linecap="round"/>
        </svg>

        <!-- PHPUnit -->
        <svg v-else-if="kind === 'phpunit'" viewBox="0 0 100 100" class="h-4/5 w-4/5" xmlns="http://www.w3.org/2000/svg">
            <rect width="100" height="100" rx="14" fill="#777BB4"/>
            <rect x="38" y="18" width="24" height="42" rx="4" fill="white" opacity="0.95"/>
            <path d="M34 60 L50 82 L66 60" fill="#4CAF50" opacity="0.9"/>
        </svg>

        <!-- Agile / Scrum -->
        <svg v-else-if="kind === 'agile'" viewBox="0 0 100 100" class="h-4/5 w-4/5 text-[#1b1b18] dark:text-[#EDEDEC]" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 15 A35 35 0 1 1 15 50" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round" opacity="0.9"/>
            <polygon points="8,38 22,44 18,58" fill="currentColor" opacity="0.9"/>
            <circle cx="50" cy="50" r="5" fill="currentColor" opacity="0.8"/>
        </svg>

    </template>
</template>
