<template>
    <div class="slide">
        <h1>You consumed a total of</h1>
        <h1>
            <span class="dynamic color">{{ stats.amount }}</span>
        </h1>
        <h2>Calories this year.</h2>
        <h2>
            That's equal to
            <span class="color"
                ><span class="dynamic">{{ stats.tostis }}</span> Tostis</span
            >!
        </h2>
        <div class="tostis">
            <img
                v-for="n in stats.tostis"
                :key="n"
                :src="tosti"
                :style="`animation-delay: ${noAnimation ? -4 : (n - 1) * (4 / stats.tostis)}s`"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import tosti from '@/../assets/images/tosti.png'
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
    noAnimation?: boolean
}>()
const stats = props.data.calories
const columns = Math.round(Math.sqrt(stats.tostis / 2))
</script>

<style scoped>
.slide {
    background: rgb(119, 75, 198);
    background: linear-gradient(
        48deg,
        rgba(119, 75, 198, 1) 20%,
        rgba(135, 173, 250, 1) 87%
    );
    text-align: center;
}

.color {
    color: #8bfc71;
}

.container {
    display: flex;
    align-items: center;
    height: 40em;
}

.tostis {
    position: absolute;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap-reverse;
    justify-content: center;
    padding: 0 1rem;
    gap: 0.5rem;
    width: auto;
    bottom: 1rem;
    left: 0;
}

.tostis img {
    width: v-bind(
        '`calc(calc(100% - calc(.5rem * ${columns - 1})) / ${columns})`'
    );
    animation: drop 1s forwards cubic-bezier(0.175, 0.885, 0.32, 1.025);
    transform: translateY(-100svh);
}

@keyframes drop {
    to {
        transform: translateX(0);
    }
}
</style>
