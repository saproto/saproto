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
            <span class="dynamic total-user">{{ stats.user.total_played }}</span>
            songs!
        </h2>
        <h2 class="bottom">
            That estimates to
            <span class="dynamic duration">{{ stats.user.duration_played }}</span> of music
        </h2>

        <h1 class="bottom">
            You are in the top
            <span class="dynamic percentile">{{ stats.user.percentile }}%</span> of users
        </h1>

        <div class="protube">
            <img v-for="i in 100"
                 :class="i>stats.user.percentile?'red':''" id="protubeLogo" :style="`animation-delay:${(100-i) * 0.05}s`" :src="data.images.proTubeLogo" />
        </div>

        <!--        <h1>Your most played video:</h1>-->
        <!--        <div style="height: 8rem; display: flex; justify-content: center">-->
        <!--            <div class="">-->
        <!--&lt;!&ndash;                <img :src="`https://img.youtube.com/vi/${stats.videos[0].video_id}/mqdefault.jpg`">&ndash;&gt;-->
        <!--                <h1>{{ stats.videos[0].video_title }}</h1>-->
        <!--                <iframe id="player" type="text/html" width="640" height="390"-->
        <!--                        :src="`http://www.youtube.com/embed/${stats.videos[0].video_id}?enablejsapi=1&?autoplay=1`"-->
        <!--                        frameborder="0"></iframe>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <h1>-->
        <!--            You bought a total of-->
        <!--&lt;!&ndash;            <span class="dynamic">{{ stats.items[0][1] }}</span>!&ndash;&gt;-->
        <!--        </h1>-->
        <!--        <h2 v-if="stats.percentile === 0">-->
        <!--            You're the <span class="dynamic">top</span> buyer of this product!-->
        <!--        </h2>-->
        <!--        <h2 v-else>-->
        <!--            That puts you in the top-->
        <!--            <span class="dynamic">{{ stats.percentile }}%</span> of buyers.-->
        <!--        </h2>-->
        <!--        <br>-->
        <!--        <h2>Your other favourite products were:</h2>-->
        <!--        <br>-->
        <!--        <div class="product-list">-->
        <!--            <div-->
        <!--                v-for="(item, index) in stats.videos.slice(1,5)"-->
        <!--                :key="index"-->
        <!--                class="product-line"-->
        <!--            >-->
        <!--                <div style="font-size: 1.2em">-->
        <!--                    {{ index + 2 }}.-->
        <!--                </div>-->
        <!--                <div class="product-card">-->
        <!--&lt;!&ndash;                    <img&ndash;&gt;-->
        <!--&lt;!&ndash;                        v-if="item[0]['image_url']"&ndash;&gt;-->
        <!--&lt;!&ndash;                        :src="item[0]['image_url']"&ndash;&gt;-->
        <!--&lt;!&ndash;                    >&ndash;&gt;-->
        <!--                    <img :src="`https://img.youtube.com/vi/${item.video_id}/mqdefault.jpg`">-->
        <!--                    <div class="textbox">-->
        <!--&lt;!&ndash;                        <h2>{{ item[0]['name'] }}</h2>&ndash;&gt;-->
        <!--&lt;!&ndash;                        <h2 style="text-overflow: unset; overflow: unset">&ndash;&gt;-->
        <!--&lt;!&ndash;                            {{ item[1] }}&ndash;&gt;-->
        <!--&lt;!&ndash;                        </h2>&ndash;&gt;-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
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

.bottom{
    margin-bottom: 1rem;
}

.total {
    color: #E01305;
}
.total-user{
    color: #7D58D9;
}
.duration{
    color: #E1E1E1;
}

.percentile{
    color: #95E913;
}

.protube{
    gap: 0.1rem;
    display: grid;
    grid-template-columns: repeat(10, auto);
    margin-top: 2rem;
}

.red{
    animation-name: reveal;
    animation-duration: 1s;
    animation-fill-mode: forwards;
    filter: grayscale(0);
}

@keyframes reveal {
    from {filter: grayscale(0);}
    to {filter: grayscale(1);}
}
</style>
