<script setup lang="ts">
import unicorn from '@/../assets/images/unicorn.png'
import unicornBw from '@/../assets/images/unicorn_bw.png'
import { statsType } from '@/pages/Wrapped/types.ts'

const props = defineProps<{
    data: statsType
    noAnimation: boolean
}>()
const stats = props.data.willToLives
</script>
<template>
    <div class="slide">
        <div class="card">
            <h1>This year you needed</h1>
            <h1 class="color-text">
                <span class="dynamic">{{ stats.amount }}</span> will to lives.
            </h1>
            <h2>
                That places you in the top
                <span class="dynamic color-text">{{ stats.percentile }}%</span>
            </h2>

            <h2 v-if="stats.percentile > 80">Must have been a great year.</h2>
            <h2 v-else-if="stats.percentile > 50">
                Must have been an average year.
            </h2>
            <h2 v-else-if="stats.percentile > 30">
                Must have been an rough year.
            </h2>
            <h2 v-else-if="stats.percentile > 10">Are you okay?</h2>
            <h2 v-else>At least next year can't get any worse.</h2>
        </div>
        <div class="container">
            <div
                class="grayscale"
                :style="`background-image: url(${unicornBw})`"
            />
            <div
                class="color"
                :style="`background-image: url(${unicorn}); animation-iteration-count: ${stats.percentage}; animation-duration: ${4 / stats.percentage}s`"
            />
        </div>
    </div>
</template>

<style scoped>
.slide {
    background: rgb(243, 127, 247);
    background: linear-gradient(
        236deg,
        rgba(243, 127, 247, 1) 0%,
        rgba(251, 196, 131, 1) 51%,
        rgba(0, 212, 255, 1) 100%
    );
    text-align: center;
}

.color-text {
    color: #50f8eb;
}

.card {
    background: rgba(150, 150, 150, 0.6);
    border-radius: 1rem;
    padding: 1rem;
    margin-top: 2rem;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 0.3rem 0.3rem;
}

.container {
    position: relative;
    height: 40rem;
}

.container div {
    position: absolute;
    background-repeat: no-repeat;
    background-position: bottom;
    background-size: 25rem;
    width: 100%;
}

.grayscale {
    top: 9rem;
    height: 17rem;
}

.color {
    top: 10rem;
    height: 16rem;
    animation: fillColor 6s forwards linear;
    animation-delay: v-bind('noAnimation ? "-6s" : "0"');
}

@keyframes fillColor {
    from {
        top: 23rem;
        height: 3rem;
    }
}
</style>
