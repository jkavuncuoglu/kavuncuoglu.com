<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

interface CPath { d: string; len: number; delay: number; dur: number; }
interface CPad  { cx: number; cy: number; r: number; glow: boolean; delay: number; }

const GRID     = 64;   // grid cell size (px)
const N_PATHS  = 48;   // number of circuit traces to generate

// Deterministic Park-Miller PRNG so layout is stable across re-mounts
function makePrng(seed: number) {
    let s = seed;
    return () => {
        s = (s * 16807) % 2147483647;
        return (s - 1) / 2147483646;
    };
}

function buildCircuit(w: number, h: number) {
    const rng  = makePrng(1984);
    const cols = Math.ceil(w / GRID) + 1;
    const rows = Math.ceil(h / GRID) + 1;
    const paths: CPath[] = [];
    const pads:  CPad[]  = [];

    for (let i = 0; i < N_PATHS; i++) {
        // Snap start to grid
        let x = Math.floor(rng() * cols) * GRID;
        let y = Math.floor(rng() * rows) * GRID;

        const pts: { x: number; y: number }[] = [{ x, y }];
        let horiz = rng() > 0.5;
        const segs = Math.floor(rng() * 3) + 1; // 1-3 segments per trace

        for (let s = 0; s < segs; s++) {
            const len  = (Math.floor(rng() * 6) + 1) * GRID;
            const sign = rng() > 0.5 ? 1 : -1;
            if (horiz) x = Math.max(-GRID, Math.min(w + GRID, x + sign * len));
            else        y = Math.max(-GRID, Math.min(h + GRID, y + sign * len));
            pts.push({ x, y });
            horiz = !horiz;
        }

        // Compute true Manhattan length
        let totalLen = 0;
        for (let p = 1; p < pts.length; p++) {
            totalLen += Math.abs(pts[p].x - pts[p - 1].x)
                      + Math.abs(pts[p].y - pts[p - 1].y);
        }
        if (totalLen < GRID) continue; // skip degenerate paths

        // Build SVG path string
        let d = `M${pts[0].x},${pts[0].y}`;
        for (let p = 1; p < pts.length; p++) {
            d += ` L${pts[p].x},${pts[p].y}`;
        }

        paths.push({
            d,
            len:   totalLen,
            delay: rng() * 3.8,            // staggered draw start (0-3.8 s)
            dur:   rng() * 1.5 + 1.2,      // draw duration (1.2-2.7 s)
        });

        // Place junction pads at every vertex
        pts.forEach((pt, idx) => {
            const isEndpoint = idx === 0 || idx === pts.length - 1;
            pads.push({
                cx:    pt.x,
                cy:    pt.y,
                r:     isEndpoint ? 3.5 : 2.5,
                glow:  rng() < 0.08,       // ~8 % get a blue glow
                delay: rng() * 3.5 + 0.4,
            });
        });
    }

    return { paths, pads };
}

const containerRef = ref<HTMLDivElement | null>(null);
const svgW  = ref(0);
const svgH  = ref(0);
const paths = ref<CPath[]>([]);
const pads  = ref<CPad[]>([]);

let ro: ResizeObserver | null = null;

function rebuild(w: number, h: number) {
    svgW.value = Math.ceil(w);
    svgH.value = Math.ceil(h);
    const { paths: p, pads: d } = buildCircuit(w, h);
    paths.value = p;
    pads.value  = d;
}

onMounted(() => {
    const el = containerRef.value;
    if (!el) return;

    ro = new ResizeObserver((entries) => {
        const { width, height } = entries[0].contentRect;
        if (width > 0 && height > 0) rebuild(width, height);
    });
    ro.observe(el);
});

onUnmounted(() => ro?.disconnect());
</script>

<template>
    <div
        ref="containerRef"
        class="circuit-bg pointer-events-none absolute inset-0 overflow-hidden"
        aria-hidden="true"
    >
        <svg
            v-if="svgW && svgH"
            :width="svgW"
            :height="svgH"
            xmlns="http://www.w3.org/2000/svg"
            class="absolute inset-0"
        >
            <defs>
                <!-- Glow filter for accent nodes -->
                <filter id="cb-glow" x="-120%" y="-120%" width="340%" height="340%">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur" />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>

            <!-- ── Circuit traces ── -->
            <path
                v-for="(p, i) in paths"
                :key="`p${i}`"
                :d="p.d"
                fill="none"
                stroke-width="1"
                stroke-linecap="square"
                :stroke-dasharray="p.len"
                class="cpath"
                :style="{
                    '--len': p.len,
                    'animation-delay':    `${p.delay}s`,
                    'animation-duration': `${p.dur}s`,
                }"
            />

            <!-- ── Junction pads ── -->
            <circle
                v-for="(pd, i) in pads"
                :key="`d${i}`"
                :cx="pd.cx"
                :cy="pd.cy"
                :r="pd.r"
                :filter="pd.glow ? 'url(#cb-glow)' : undefined"
                :class="pd.glow ? 'cpad-glow' : 'cpad'"
                :style="{ 'animation-delay': `${pd.delay}s` }"
            />
        </svg>
    </div>
</template>

<style scoped>
/* ────────────────────────────────────────────────────────────
   Light-mode defaults
   ──────────────────────────────────────────────────────────── */
.cpath {
    stroke: rgba(80, 120, 175, 0.14);
    stroke-dashoffset: var(--len);
    animation-name:            draw-trace;
    animation-duration:        2s;         /* fallback; overridden per-element */
    animation-timing-function: ease-out;
    animation-fill-mode:       both;
}

.cpad {
    fill: rgba(80, 120, 185, 0.22);
    animation-name:            pop-pad;
    animation-duration:        0.5s;
    animation-timing-function: ease-out;
    animation-fill-mode:       both;
    transform-box:             fill-box;
    transform-origin:          center;
}

.cpad-glow {
    fill: rgba(59, 130, 246, 0.70);
    animation-name:            pop-pad;
    animation-duration:        0.6s;
    animation-timing-function: ease-out;
    animation-fill-mode:       both;
    transform-box:             fill-box;
    transform-origin:          center;
}

/* ────────────────────────────────────────────────────────────
   Dark-mode overrides
   ──────────────────────────────────────────────────────────── */
:global(.dark) .cpath     { stroke: rgba(14,  100, 200, 0.38); }
:global(.dark) .cpad      { fill:   rgba(14,  165, 233, 0.48); }
:global(.dark) .cpad-glow { fill:   rgba(56,  189, 248, 1.00); }

/* ────────────────────────────────────────────────────────────
   Keyframes
   ──────────────────────────────────────────────────────────── */

/* Trace draws itself in like a PCB router */
@keyframes draw-trace {
    0%  { stroke-dashoffset: var(--len); opacity: 0; }
    6%  { opacity: 1; }
    100%{ stroke-dashoffset: 0;          opacity: 1; }
}

/* Node pops into existence from center */
@keyframes pop-pad {
    from { opacity: 0; transform: scale(0.1); }
    to   { opacity: 1; transform: scale(1);   }
}
</style>
