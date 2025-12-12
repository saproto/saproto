<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types.ts'

const props = defineProps<{
    data: statsType
    noAnimation: boolean
}>()
const stats = props.data.koenkert
</script>
<template>
    <div class="slide">
        <div class="card">
            <h1>Based on your purchases this year</h1>
            <h1 class="color-text">
                <span class="dynamic">{{ stats.type }}</span> 
            </h1>
            <h1>would be your best freind </h1>
        </div>
         <div class="container">
            <div
                class="color"
                :style="`background-image: url(${stats.imageName});`"
            />
        </div>
    </div>
</template>

<style scoped>
.slide {
    background: rgb(106, 255, 57);
    background: linear-gradient(
        -236deg,
        rgb(214, 51, 51) 0%,
        rgb(48, 112, 242) 80%
    );
    text-align: center;
}

.color-text {
    color: #50f8eb;
}

.card {
    /* background: rgba(150, 150, 150, 0.6);
    border-radius: 1rem; */
    padding: 1rem;
    margin-top: 2rem;
    /* box-shadow: rgba(255, 255, 255, 0.2) 0 0 0.3rem 0.3rem; */
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
    height: 30rem;
}

@keyframes fillColor {
    from {
        top: 23rem;
        height: 3rem;
    }
}
</style>
