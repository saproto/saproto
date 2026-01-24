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
      <h1>The Cookie monster</h1>
      <h1>you vibed with</h1>
      <h1>the most this year is:</h1>
      <h1 class="color-text">
        <span class="dynamic">{{ stats.type }}</span>
      </h1>
    </div>
    <img
      class="koenkertImage"
      :src="stats.imageName"
      alt="Cookie Monster"
    >
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

.koenkertImage {
    corner-shape: scoop;
    border-radius: 2rem;
    padding: 1rem;
}

.color-text {
    margin-top: 0.5rem;
    color: #50f8eb;
}

.card {
    /* background: rgba(150, 150, 150, 0.6);
    border-radius: 1rem; */
    padding: 1rem;
    margin-top: 2rem;
    /* box-shadow: rgba(255, 255, 255, 0.2) 0 0 0.3rem 0.3rem; */
}

.container div {
    position: absolute;
    background-repeat: no-repeat;
    background-size: 25rem;
    width: 27rem;
}

.grayscale {
    top: 9rem;
    height: 17rem;
}

.color {
    height: 29rem;
}

@keyframes fillColor {
    from {
        top: 23rem;
        height: 3rem;
    }
}
</style>
