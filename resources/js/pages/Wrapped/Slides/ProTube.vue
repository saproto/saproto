<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.protube
</script>
<template>
    <div class="slide">
        <h1>This year ProTube has played</h1>
        <h1 class="bottom">
            <span class="dynamic total">{{ stats.total.total_played }}</span>
            songs!
        </h1>
        <h2>
            You have put in
            <span class="dynamic total-user">{{
                stats.user.total_played
            }}</span>
            songs!
        </h2>
        <h2 class="bottom">
            That estimates to
            <span class="dynamic duration">{{
                stats.user.duration_played
            }}</span>
            of music
        </h2>

        <h1 class="bottom">
            You are in the top
            <span class="dynamic percentile">{{ stats.user.percentile }}%</span>
            of users
        </h1>

        <div class="protube">
            <img
                v-for="i in 100"
                id="protubeLogo"
                :key="i"
                :class="i > stats.user.percentile ? 'red' : ''"
                :style="`animation-delay:${(100 - i) * 0.05}s`"
                :src="data.images.proTubeLogo"
            />
        </div>
    </div>
</template>

<style scoped>
.slide {
    padding: 2rem 1rem 1rem;
    background: #2a7b9b;
    background: radial-gradient(
        circle,
        rgba(42, 123, 155, 1) 0%,
        rgba(87, 199, 133, 1) 50%,
        rgba(237, 221, 83, 1) 100%
    );
    text-align: center;
}

.bottom {
    margin-bottom: 1rem;
}

.total {
    color: #e01305;
}
.total-user {
    color: #7d58d9;
}
.duration {
    color: #e1e1e1;
}

.percentile {
    color: #95e913;
}

.protube {
    gap: 0.1rem;
    display: grid;
    grid-template-columns: repeat(10, auto);
    margin-top: 2rem;
}

.red {
    animation-name: reveal;
    animation-duration: 1s;
    animation-fill-mode: forwards;
    filter: grayscale(0);
}

@keyframes reveal {
    from {
        filter: grayscale(0);
    }
    to {
        filter: grayscale(1);
    }
}
</style>
