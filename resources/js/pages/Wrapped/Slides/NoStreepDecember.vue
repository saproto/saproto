<template>
    <div class="slide">
        <h1>In case you tried to participate in No-Stripe-December:</h1>
        <div v-if="stats.complete">
            <h2>You made it!</h2>
            <h2>Congratulations!</h2>
        </div>
        <div v-else>
            <h2>You failed!</h2>
            <h3>You still bought {{ stats.items }} items in December.</h3>
        </div>
<!--        <h2>{{ stats.winners }} others managed to complete it.</h2>-->
    </div>
</template>

<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.december
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
</style>
