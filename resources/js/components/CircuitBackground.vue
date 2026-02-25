<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

interface CPath {
    d: string;
    len: number;
    delay: number;
    dur: number;
    width: number;
    lit: boolean;
    burst: number;   // number of streak iterations for this activation (3–6)
    opacity: number; // per-trace base opacity (0.10–0.28)
}
interface CPad {
    cx: number;
    cy: number;
    r: number;
    kind: 'pad' | 'glow';
    delay: number;
}
interface CPin {
    px: number;
    py: number;
    lx: number;
    ly: number;
} // pad + lead anchor
interface CChip {
    x: number;
    y: number;
    w: number;
    h: number;
    hLines: number[]; // y-offsets (relative to chip.y) for inner horizontal lines
    vLines: number[]; // x-offsets (relative to chip.x) for inner vertical lines
    pins: CPin[];
    lit: boolean;
}

const GRID = 24; // denser grid cell (px)
const N_PATHS = 130; // circuit traces
const N_CHIPS = 7; // IC chips

function makePrng(seed: number) {
    let s = seed;
    return () => {
        s = (s * 16807) % 2147483647;
        return (s - 1) / 2147483646;
    };
}

function buildChips(w: number, h: number, rng: () => number): CChip[] {
    const chips: CChip[] = [];
    for (let i = 0; i < N_CHIPS; i++) {
        const cols = Math.floor(rng() * 4) + 3; // 3–6 cells wide
        const rows = Math.floor(rng() * 3) + 2; // 2–4 cells tall
        const cw = cols * GRID;
        const ch = rows * GRID;
        const maxCx = Math.floor((w - cw) / GRID);
        const maxCy = Math.floor((h - ch) / GRID);
        if (maxCx < 1 || maxCy < 1) continue;

        const cx = Math.floor(rng() * maxCx) * GRID;
        const cy = Math.floor(rng() * maxCy) * GRID;

        // Inner dividing lines
        const hLines: number[] = [];
        for (let r = 1; r < rows; r++) hLines.push(r * GRID);
        const vLines: number[] = [];
        for (let c = 1; c < cols; c++) vLines.push(c * GRID);

        // Pin pads with pre-computed lead anchor (the point touching the chip edge)
        const pins: CPin[] = [];
        for (let c = 0; c < cols; c++) {
            const px = cx + c * GRID + GRID / 2;
            pins.push({ px, py: cy, lx: px, ly: cy + 5 }); // top
            pins.push({ px, py: cy + ch, lx: px, ly: cy + ch - 5 }); // bottom
        }
        for (let r = 0; r < rows; r++) {
            const py = cy + r * GRID + GRID / 2;
            pins.push({ px: cx, py, lx: cx + 5, ly: py }); // left
            pins.push({ px: cx + cw, py, lx: cx + cw - 5, ly: py }); // right
        }

        chips.push({ x: cx, y: cy, w: cw, h: ch, hLines, vLines, pins, lit: false });
    }
    return chips;
}

const CORNER_R = GRID * 0.38; // ~9px radius for rounded PCB corners

function buildCircuit(w: number, h: number) {
    const rng = makePrng(1984);
    const cols = Math.ceil(w / GRID) + 1;
    const rows = Math.ceil(h / GRID) + 1;
    const paths: CPath[] = [];
    const pads: CPad[] = [];
    const chips = buildChips(w, h, rng);

    for (let i = 0; i < N_PATHS; i++) {
        let x = Math.floor(rng() * cols) * GRID;
        let y = Math.floor(rng() * rows) * GRID;
        const pts: { x: number; y: number }[] = [{ x, y }];
        let horiz = rng() > 0.5;
        const segs = Math.floor(rng() * 5) + 2; // 2–6 segments

        for (let s = 0; s < segs; s++) {
            const segLen = (Math.floor(rng() * 8) + 2) * GRID;
            const sign = rng() > 0.5 ? 1 : -1;
            if (horiz)
                x = Math.max(-GRID, Math.min(w + GRID, x + sign * segLen));
            else y = Math.max(-GRID, Math.min(h + GRID, y + sign * segLen));
            pts.push({ x, y });
            horiz = !horiz;
        }

        let totalLen = 0;
        for (let p = 1; p < pts.length; p++) {
            totalLen +=
                Math.abs(pts[p].x - pts[p - 1].x) +
                Math.abs(pts[p].y - pts[p - 1].y);
        }
        if (totalLen < GRID * 2) continue;

        // Build path with rounded corners at intermediate turning points
        let d = `M${pts[0].x},${pts[0].y}`;
        for (let p = 1; p < pts.length; p++) {
            if (p < pts.length - 1) {
                const A = pts[p - 1], B = pts[p], C = pts[p + 1];
                const dx1 = B.x - A.x, dy1 = B.y - A.y;
                const len1 = Math.abs(dx1) + Math.abs(dy1);
                const dx2 = C.x - B.x, dy2 = C.y - B.y;
                const len2 = Math.abs(dx2) + Math.abs(dy2);
                const r = Math.min(CORNER_R, len1 * 0.45, len2 * 0.45);
                const ux1 = dx1 / len1, uy1 = dy1 / len1;
                const ux2 = dx2 / len2, uy2 = dy2 / len2;
                const p1x = B.x - ux1 * r, p1y = B.y - uy1 * r;
                const p2x = B.x + ux2 * r, p2y = B.y + uy2 * r;
                d += ` L${p1x},${p1y} Q${B.x},${B.y} ${p2x},${p2y}`;
            } else {
                d += ` L${pts[p].x},${pts[p].y}`;
            }
        }

        const width = +(rng() * 1.8 + 0.4).toFixed(1); // 0.4–2.2px
        const opacity = +(0.10 + rng() * 0.18).toFixed(2); // 0.10–0.28
        paths.push({
            d,
            len: totalLen,
            delay: rng() * 4.5,
            dur: rng() * 1.8 + 1.0,
            width,
            lit: false,
            burst: 0,
            opacity,
        });

        pts.forEach((pt, idx) => {
            const ep = idx === 0 || idx === pts.length - 1;
            // endpoint and mid-point circles scale with line width
            const r = ep
                ? +(1.5 + width * 1.0).toFixed(1)   // 2.0 → 6.0
                : +(0.8 + width * 0.7).toFixed(1);   // 1.15 → 3.95
            pads.push({
                cx: pt.x,
                cy: pt.y,
                r,
                kind: rng() < 0.07 ? 'glow' : 'pad',
                delay: rng() * 4.5,
            });
        });
    }

    return { paths, pads, chips };
}

const containerRef = ref<HTMLDivElement | null>(null);
const svgW = ref(0);
const svgH = ref(0);
const paths = ref<CPath[]>([]);
const pads = ref<CPad[]>([]);
const chips = ref<CChip[]>([]);

let litSet: Set<number> = new Set();
let litChipSet: Set<number> = new Set();
let ro: ResizeObserver | null = null;
let ticker: ReturnType<typeof setInterval> | null = null;
const burstTimeouts: Map<number, ReturnType<typeof setTimeout>> = new Map();

function rebuild(w: number, h: number) {
    burstTimeouts.forEach((t) => clearTimeout(t));
    burstTimeouts.clear();
    svgW.value = Math.ceil(w);
    svgH.value = Math.ceil(h);
    const built = buildCircuit(w, h);
    paths.value = built.paths;
    pads.value = built.pads;
    chips.value = built.chips;
    litSet.clear();
    litChipSet.clear();
}

function pulse() {
    // Cancel pending burst timeouts and turn off paths that were lit
    litSet.forEach((i) => {
        if (burstTimeouts.has(i)) {
            clearTimeout(burstTimeouts.get(i)!);
            burstTimeouts.delete(i);
        }
        if (paths.value[i]) paths.value[i].lit = false;
    });
    litSet.clear();

    const count = Math.floor(Math.random() * 10) + 5;
    while (litSet.size < Math.min(count, paths.value.length)) {
        litSet.add(Math.floor(Math.random() * paths.value.length));
    }

    litSet.forEach((i) => {
        if (!paths.value[i]) return;
        const burst = Math.floor(Math.random() * 3) + 2; // 2–4 iterations
        paths.value[i].burst = burst;
        paths.value[i].lit = true;
        const t = setTimeout(() => {
            if (paths.value[i]) paths.value[i].lit = false;
            burstTimeouts.delete(i);
        }, burst * 500 + 200);
        burstTimeouts.set(i, t);
    });

    // Randomly light 0–2 chips per pulse
    litChipSet.forEach((i) => {
        if (chips.value[i]) chips.value[i].lit = false;
    });
    litChipSet.clear();
    const chipCount = Math.floor(Math.random() * 3); // 0, 1, or 2
    while (litChipSet.size < Math.min(chipCount, chips.value.length)) {
        litChipSet.add(Math.floor(Math.random() * chips.value.length));
    }
    litChipSet.forEach((i) => {
        if (chips.value[i]) chips.value[i].lit = true;
    });
}

onMounted(() => {
    const el = containerRef.value;
    if (!el) return;

    ro = new ResizeObserver((entries) => {
        const { width, height } = entries[0].contentRect;
        if (width > 0 && height > 0) rebuild(width, height);
    });
    ro.observe(el);

    // Start electricity pulses after draw animations settle
    setTimeout(() => {
        pulse();
        ticker = setInterval(pulse, 1500);
    }, 4000);
});

onUnmounted(() => {
    ro?.disconnect();
    if (ticker) clearInterval(ticker);
    burstTimeouts.forEach((t) => clearTimeout(t));
    burstTimeouts.clear();
});
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
                <!-- Soft junction glow -->
                <filter
                    id="cb-glow"
                    x="-80%"
                    y="-80%"
                    width="260%"
                    height="260%"
                >
                    <feGaussianBlur
                        in="SourceGraphic"
                        stdDeviation="3.5"
                        result="blur"
                    />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>

                <!-- Strong blue electricity glow -->
                <filter
                    id="cb-glow-elec"
                    x="-120%"
                    y="-120%"
                    width="340%"
                    height="340%"
                >
                    <feGaussianBlur
                        in="SourceGraphic"
                        stdDeviation="5"
                        result="blur"
                    />
                    <feColorMatrix
                        in="blur"
                        type="matrix"
                        values="0 0 0 0 0.15  0 0 0 0 0.55  0 0 0 0 1.0  0 0 0 5 0"
                        result="colored"
                    />
                    <feMerge>
                        <feMergeNode in="colored" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>

                <!-- Subtle chip pin glow -->
                <filter
                    id="cb-chip-glow"
                    x="-80%"
                    y="-80%"
                    width="260%"
                    height="260%"
                >
                    <feGaussianBlur
                        in="SourceGraphic"
                        stdDeviation="2"
                        result="blur"
                    />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>

            <!-- ── IC Chips (rendered below traces) ── -->
            <g v-for="(chip, ci) in chips" :key="`chip${ci}`">
                <!-- Chip outer body -->
                <rect
                    :x="chip.x"
                    :y="chip.y"
                    :width="chip.w"
                    :height="chip.h"
                    rx="3"
                    :class="['chip-body', chip.lit && 'chip-body-lit']"
                />
                <!-- Chip inner die area -->
                <rect
                    :x="chip.x + 7"
                    :y="chip.y + 7"
                    :width="chip.w - 14"
                    :height="chip.h - 14"
                    rx="2"
                    :class="['chip-die', chip.lit && 'chip-die-lit']"
                />
                <!-- Inner horizontal dividing lines -->
                <line
                    v-for="(hy, li) in chip.hLines"
                    :key="`ch${ci}h${li}`"
                    :x1="chip.x + 9"
                    :y1="chip.y + hy"
                    :x2="chip.x + chip.w - 9"
                    :y2="chip.y + hy"
                    :class="['chip-grid', chip.lit && 'chip-grid-lit']"
                />
                <!-- Inner vertical dividing lines -->
                <line
                    v-for="(vx, li) in chip.vLines"
                    :key="`ch${ci}v${li}`"
                    :x1="chip.x + vx"
                    :y1="chip.y + 9"
                    :x2="chip.x + vx"
                    :y2="chip.y + chip.h - 9"
                    :class="['chip-grid', chip.lit && 'chip-grid-lit']"
                />
                <!-- Pin lead stubs (pad → chip edge) -->
                <line
                    v-for="(pin, pi) in chip.pins"
                    :key="`ch${ci}pl${pi}`"
                    :x1="pin.px"
                    :y1="pin.py"
                    :x2="pin.lx"
                    :y2="pin.ly"
                    :class="['chip-pin-lead', chip.lit && 'chip-pin-lead-lit']"
                />
                <!-- Pin pads -->
                <circle
                    v-for="(pin, pi) in chip.pins"
                    :key="`ch${ci}pp${pi}`"
                    :cx="pin.px"
                    :cy="pin.py"
                    r="2.5"
                    :filter="chip.lit ? 'url(#cb-glow-elec)' : 'url(#cb-chip-glow)'"
                    :class="['chip-pin', chip.lit && 'chip-pin-lit']"
                />
            </g>

            <!-- ── Base circuit traces ── -->
            <path
                v-for="(p, i) in paths"
                :key="`p${i}`"
                :d="p.d"
                fill="none"
                :stroke-width="p.width"
                stroke-linecap="round"
                stroke-linejoin="round"
                :stroke-dasharray="p.len"
                :class="['cpath', p.lit && 'cpath-lit']"
                :style="{
                    '--len': p.len,
                    'animation-delay': `${p.delay}s`,
                    'animation-duration': `${p.dur}s`,
                    'opacity': p.opacity,
                }"
            />

            <!-- ── Electricity streak overlays ── -->
            <!-- v-if remounts the element each pulse, restarting the animation -->
            <template v-for="(p, i) in paths" :key="`e${i}`">
                <path
                    v-if="p.lit"
                    :d="p.d"
                    fill="none"
                    :stroke-width="Math.max(p.width + 0.6, 1.6)"
                    stroke-linecap="round"
                    filter="url(#cb-glow-elec)"
                    class="cpath-elec"
                    :style="{
                        '--len': p.len,
                        'animation-iteration-count': p.burst,
                        'animation-duration': '0.5s',
                    }"
                />
            </template>

            <!-- ── Junction pads ── -->
            <circle
                v-for="(pd, i) in pads"
                :key="`d${i}`"
                :cx="pd.cx"
                :cy="pd.cy"
                :r="pd.r"
                :filter="pd.kind === 'glow' ? 'url(#cb-glow)' : undefined"
                :class="pd.kind === 'glow' ? 'cpad-glow' : 'cpad'"
                :style="{ 'animation-delay': `${pd.delay}s` }"
            />
        </svg>
    </div>
</template>

<style scoped>
/* ─────────────────────────────────────────────────────────────
   IC Chip elements – light mode
   ───────────────────────────────────────────────────────────── */
.chip-body {
    fill: rgba(70, 110, 170, 0.06);
    stroke: rgba(80, 130, 200, 0.2);
    stroke-width: 1;
}
.chip-die {
    fill: rgba(50, 90, 155, 0.05);
    stroke: rgba(80, 130, 200, 0.11);
    stroke-width: 0.5;
}
.chip-grid {
    stroke: rgba(80, 130, 200, 0.08);
    stroke-width: 0.5;
}
.chip-pin-lead {
    stroke: rgba(80, 130, 200, 0.18);
    stroke-width: 0.8;
}
.chip-pin {
    fill: rgba(80, 130, 190, 0.3);
    stroke: rgba(100, 150, 220, 0.2);
    stroke-width: 0.5;
    transition: fill 0.35s ease, stroke 0.35s ease;
}

/* ── Lit (glowing) chip state – light mode ── */
.chip-body-lit {
    fill: rgba(59, 130, 246, 0.12);
    stroke: rgba(59, 130, 246, 0.55);
    filter: url(#cb-glow);
    transition: fill 0.35s ease, stroke 0.35s ease, filter 0.35s ease;
}
.chip-die-lit {
    fill: rgba(59, 130, 246, 0.1);
    stroke: rgba(59, 130, 246, 0.4);
    transition: fill 0.35s ease, stroke 0.35s ease;
}
.chip-grid-lit {
    stroke: rgba(59, 130, 246, 0.35);
    transition: stroke 0.35s ease;
}
.chip-pin-lead-lit {
    stroke: rgba(59, 130, 246, 0.6);
    transition: stroke 0.35s ease;
}
.chip-pin-lit {
    fill: rgba(59, 130, 246, 0.85);
    stroke: rgba(147, 197, 253, 0.7);
}

/* ─────────────────────────────────────────────────────────────
   Circuit traces – light mode
   ───────────────────────────────────────────────────────────── */
.cpath {
    stroke: rgba(80, 120, 175, 0.17);
    stroke-dashoffset: var(--len);
    animation-name: draw-trace;
    animation-timing-function: ease-out;
    animation-fill-mode: both;
    transition:
        stroke 0.35s ease,
        filter 0.35s ease;
}
.cpath-lit {
    stroke: rgba(59, 130, 246, 0.62);
    filter: url(#cb-glow);
}

/* Junction pads */
.cpad {
    fill: rgba(80, 120, 185, 0.22);
    animation-name: pop-pad;
    animation-duration: 0.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: both;
    transform-box: fill-box;
    transform-origin: center;
}
.cpad-glow {
    fill: rgba(59, 130, 246, 0.72);
    animation-name: pop-pad;
    animation-duration: 0.6s;
    animation-timing-function: ease-out;
    animation-fill-mode: both;
    transform-box: fill-box;
    transform-origin: center;
}

/* Electricity streak overlay — duration and iteration-count set via inline style */
.cpath-elec {
    stroke: rgba(147, 210, 255, 0.96);
    stroke-dasharray: 55 99999;
    stroke-dashoffset: 55;
    animation-name: elec-streak;
    animation-timing-function: linear;
    animation-fill-mode: none;
}

/* ─────────────────────────────────────────────────────────────
   Dark-mode overrides
   ───────────────────────────────────────────────────────────── */
:global(.dark) .chip-body {
    fill: rgba(8, 25, 70, 0.6);
    stroke: rgba(20, 90, 200, 0.5);
}
:global(.dark) .chip-die {
    fill: rgba(4, 15, 55, 0.7);
    stroke: rgba(15, 70, 200, 0.35);
}
:global(.dark) .chip-grid {
    stroke: rgba(15, 70, 200, 0.24);
}
:global(.dark) .chip-pin-lead {
    stroke: rgba(20, 100, 220, 0.45);
}
:global(.dark) .chip-pin {
    fill: rgba(20, 100, 220, 0.68);
    stroke: rgba(50, 140, 255, 0.5);
}

/* ── Lit chip state – dark mode ── */
:global(.dark) .chip-body-lit {
    fill: rgba(30, 80, 200, 0.25);
    stroke: rgba(96, 165, 250, 0.75);
    filter: url(#cb-glow);
}
:global(.dark) .chip-die-lit {
    fill: rgba(20, 60, 180, 0.3);
    stroke: rgba(96, 165, 250, 0.55);
}
:global(.dark) .chip-grid-lit {
    stroke: rgba(96, 165, 250, 0.5);
}
:global(.dark) .chip-pin-lead-lit {
    stroke: rgba(96, 165, 250, 0.8);
}
:global(.dark) .chip-pin-lit {
    fill: rgba(96, 165, 250, 1);
    stroke: rgba(186, 230, 255, 0.8);
}

:global(.dark) .cpath {
    stroke: rgba(14, 100, 200, 0.38);
}
:global(.dark) .cpath-lit {
    stroke: rgba(96, 165, 250, 0.8);
    filter: url(#cb-glow);
}
:global(.dark) .cpad {
    fill: rgba(14, 165, 233, 0.48);
}
:global(.dark) .cpad-glow {
    fill: rgba(56, 189, 248, 1);
}
:global(.dark) .cpath-elec {
    stroke: rgba(186, 230, 255, 1);
}

/* ─────────────────────────────────────────────────────────────
   Keyframes
   ───────────────────────────────────────────────────────────── */

/* Trace draws itself in like a PCB router */
@keyframes draw-trace {
    0% {
        stroke-dashoffset: var(--len);
        opacity: 0;
    }
    5% {
        opacity: 1;
    }
    100% {
        stroke-dashoffset: 0;
        opacity: 1;
    }
}

/* Junction pad pops into existence */
@keyframes pop-pad {
    from {
        opacity: 0;
        transform: scale(0.1);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/*
 * Electricity streak: animates a bright 55px dash segment from before the
 * path start (dashoffset: +55) to past the path end (dashoffset: −(len+55)).
 * iteration-count and duration are set via inline style per burst.
 * animation-fill-mode: none allows clean looping across iterations.
 */
@keyframes elec-streak {
    0% {
        stroke-dashoffset: 55;
        opacity: 0;
    }
    6% {
        opacity: 1;
    }
    94% {
        opacity: 1;
    }
    100% {
        stroke-dashoffset: calc(-1 * var(--len));
        opacity: 0;
    }
}
</style>
