<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.mostBought
</script>
<template>
    <div class="slide">
        <h1>Your most loved product:</h1>
        <div style="height: 8rem; display: flex; justify-content: center">
            <div class="product-card pulse">
                <img :src="stats.items[0][0]['image_url']" />
                <h1>{{ stats.items[0][0]['name'] }}</h1>
            </div>
        </div>
        <h1>
            You bought a total of
            <span class="dynamic">{{ stats.items[0][1] }}</span
            >!
        </h1>
        <h2 v-if="stats.percentile === 0">
            You're the <span class="dynamic">top</span> buyer of this product!
        </h2>
        <h2 v-else>
            That puts you in the top
            <span class="dynamic">{{ stats.percentile }}%</span> of buyers.
        </h2>
        <br />
        <h2>Your other favourite products were:</h2>
        <br />
        <div class="product-list">
            <div
                v-for="(item, index) in stats.items.slice(1, 5)"
                :key="index"
                class="product-line"
            >
                <div style="font-size: 1.2em">{{ index + 2 }}.</div>
                <div class="product-card">
                    <img
                        v-if="item[0]['image_url']"
                        :src="item[0]['image_url']"
                    />
                    <div class="textbox">
                        <h2>{{ item[0]['name'] }}</h2>
                        <h2 style="text-overflow: unset; overflow: unset">
                            {{ item[1] }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.slide {
    background: rgb(34, 78, 255);
    background: linear-gradient(
        149deg,
        rgba(34, 78, 255, 1) 0%,
        rgba(44, 149, 155, 1) 49%,
        rgba(38, 159, 108, 1) 98%
    );
    text-align: center;
}

.dynamic {
    color: #c7ef00;
}

.product-card {
    background: rgba(200, 200, 200, 0.6);
    border-radius: 1em;
    color: black;
    padding: 0;
    display: flex;
    justify-content: start;
    flex-direction: row;
    align-items: center;
    text-align: start;
    gap: 1em;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 0.3rem 0.3rem;
    overflow: hidden;
}

.product-card * {
    font-weight: normal;
}

.product-card img {
    border-radius: 1em 0 0 1em;
    height: 100%;
    aspect-ratio: 1/1;
    object-fit: contain;
}

.product-card .textbox {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1em;
    flex-grow: 1;
    padding: 0.5rem 1rem 0.5rem 0;
    min-width: 0;
}

.product-card h1,
.product-card h2 {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.product-list {
    display: flex;
    flex-direction: column;
    justify-content: start;
    gap: 1em;
}

.product-list .product-line {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
}

.product-list .product-card {
    height: 6em;
    width: 23em;
}

.pulse {
    width: 90%;
    height: 100%;
    scale: 1;
    animation: pulse 2s infinite ease-in-out;
}

@keyframes pulse {
    0% {
        transform: scale(0.98);
        box-shadow: 0 0 0 0 #c0ff3380;
    }

    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px #c0ff3300;
    }

    100% {
        transform: scale(0.98);
        box-shadow: 0 0 0 0 #c0ff3300;
    }
}
</style>
