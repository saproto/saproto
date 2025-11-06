<template>
    <div class="slide">
        <h1>This year you attended</h1>
        <h1>
            <img :src="spilledBeer" style="width: 10rem" alt="spilled beer" />
            <span class="color"
                ><span class="dynamic">{{ stats.amount }}</span> drinks</span
            >
        </h1>
        <h2>
            On average you consumed
            <span class="color"
                ><span class="dynamic">{{
                    (
                        (stats.alcoholic + stats.nonAlcoholic) /
                        stats.amount
                    ).toFixed(2)
                }}</span>
                glasses</span
            >
            per drink!
        </h2>
        <h2>
            <img :src="beugel" style="height: 1em" />
            = <span class="dynamic" style="color: lawngreen">Alcoholic</span>
            <img :src="lemonade" style="width: 1em" />
            = <span class="dynamic color">Non-Alcoholic</span>
        </h2>
        <br />
        <div id="beerStats">
            <div v-for="i in 100" :key="i">
                <img
                    :src="
                        i >
                        (stats.alcoholic /
                            (stats.alcoholic + stats.nonAlcoholic)) *
                            100
                            ? lemonade
                            : beugel
                    "
                    style="width: 2.5rem"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import spilledBeer from '@/../assets/images/spilledbeer.png'
import beugel from '@/../assets/images/beugel.webp'
import lemonade from '@/../assets/images/lemonade.png'
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.drinks
</script>

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
</style>
