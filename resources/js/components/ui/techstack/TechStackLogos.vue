<template>
    <div class="tech-stack">
        <div
            v-for="item in stack"
            :key="item.name"
            class="card"
            :style="{ borderColor: monochrome ? '#333' : item.color }"
        >
            <img src="images/brands/laravel.jpg" class="logo" />



            <svg
                class="logo"
                viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg"
            >

                <!-- CI/CD -->
                <polygon
                    v-if="item.name === 'CI/CD'"
                    :fill="logoColor(item)"
                    points="30,20 70,50 30,80"
                />

                <!-- Security -->
                <path
                    v-if="item.name === 'Security-First'"
                    :fill="logoColor(item)"
                    d="M50 15 L80 30 V55 C80 70 65 82 50 88 C35 82 20 70 20 55 V30 Z"
                />
            </svg>

            <div class="label">{{ item.name }}</div>
            <div v-if="item.sub" class="sub">{{ item.sub }}</div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

defineProps({
    monochrome: {
        type: Boolean,
        default: false
    }
});

const stack = [
    { name: "Laravel", color: "#FF2D20" },
    { name: "Vue.js", color: "#42B883" },
    { name: "AWS", color: "#FF9900", sub: "Lambda • ECS • CloudFormation" },
    { name: "Amazon Connect", color: "#FF9900", sub: "Flow Design & Config" },
    { name: "Infrastructure as Code", color: "#666" },
    { name: "CI/CD", color: "#0A66C2" },
    { name: "Security-First", color: "#ffffff" }
];

const logoColor = (item) => {
    return item.color;
};
</script>

<style scoped>
.tech-stack {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: center;
    padding: 40px 0;
    background: #0f172a; /* dark-mode optimized */
}

.card {
    width: 200px;
    height: 180px;
    border-radius: 16px;
    border: 1px solid;
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(4px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.logo {
    width: 60px;
    height: 60px;
    margin-bottom: 12px;
    transition: transform 0.3s ease;
}

.card:hover .logo {
    transform: scale(1.08);
}

.label {
    color: #fff;
    font-weight: 600;
    margin-bottom: 6px;
    text-align: center;
}

.sub {
    color: #94a3b8;
    font-size: 12px;
    text-align: center;
}
</style>
