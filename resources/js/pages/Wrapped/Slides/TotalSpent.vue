<template>
    <div class="slide">
        <h1>You spent a total of</h1>
        <h1 class="amount">
            €<span class="dynamic">{{ stats.amount.toFixed(2) }}</span>
        </h1>
        <h1>That could have gotten you</h1>
        <h1 class="torondos">
            <span class="dynamic">{{ Math.floor(stats.amount / 0.3) }}</span>
            Torondos!
        </h1>
        <h2>Together with your other Proto members you spent a total of</h2>
        <h1 class="total">
            €<span class="dynamic">{{ stats.total.toFixed(2) }}</span>
        </h1>
        <img :src="props.data.images.cookieMonster" />
    </div>
</template>

<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.totalSpent
</script>

<style scoped>
.slide {
    text-align: center;
    background: brown;
    padding-top: 3em;
}
.amount {
    color: #74ee15;
}
.torondos {
    color: #ffe700;
}
.total {
    color: #4deeea;
}
h1:nth-child(2) {
    padding-bottom: 0.5em;
}
img {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
}
</style>
