<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.drinks
</script>
<template>
  <div class="slide">
    <h1>This year you attended</h1>
    <span class="flex justify-around">
      <img
        :src="props.data.images.spilledBeer"
        style="width: 10rem"
        alt="spilled beer"
      >
      <span class="color text-4xl">
        <span class="dynamic">{{ stats.amount }}</span>
        drinks</span>
    </span>
    <h2>On average you consumed</h2>
    <h2 style="margin-top: 0">
      <span class="color"><span class="dynamic">{{
        (
          (stats.alcoholic + stats.nonAlcoholic) /
          stats.amount
        ).toFixed(2)
      }}</span>
        glasses</span>
      per drink!
    </h2>
    <h2 class="mb-3 flex justify-between">
      <img
        :src="props.data.images.beugel"
        style="height: 1.5em"
      >
      = <span
        class="dynamic"
        style="color: lawngreen"
      >Alcoholic</span>
      <img
        :src="props.data.images.lemonade"
        style="height: 1.5em"
      >
      = <span class="dynamic color">Non-Alcoholic</span>
    </h2>
    <br>
    <div id="beerStats">
      <div
        v-for="i in 100"
        :key="i"
      >
        <img
          :src="
            i >
              (stats.alcoholic /
                (stats.alcoholic + stats.nonAlcoholic)) *
              100
              ? props.data.images.lemonade
              : props.data.images.beugel
          "
          style="width: 2.5rem"
        >
      </div>
    </div>
  </div>
</template>

<style scoped>
.slide {
    background: rgb(34, 78, 255);
    background: linear-gradient(
        149deg,
        rgb(34, 78, 255) 0%,
        rgb(44, 92, 155) 49%,
        rgb(42, 40, 100) 98%
    );
    text-align: center;
}

.color {
    color: #ffe700;
}

#beerStats {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    grid-template-rows: repeat(10, 1fr);
}

h1,
h2 {
    margin-top: 1.2rem;
}
</style>
