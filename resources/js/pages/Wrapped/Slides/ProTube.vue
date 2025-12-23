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

        <h1 class="dynamic">
            <span class="color">
                {{ stats.total.total_played }}
            </span>
            video's
        </h1>
        <div>
            Of these, you put in
            <h1 class="dynamic">
                <span class="color">
                    {{ stats.user.total_played }}
                </span>
                video's
            </h1>
            <h2>
                That estimates to
                {{ stats.user.duration_played }}
            </h2>
        </div>

        <img id="protubeLogo" :src="data.images.proTubeLogo" />
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

.color {
    color: #da2c38;
}

#protubeLogo {
    position: absolute;
    bottom: 2rem;
    left: 0;
    padding: 2rem;
}
</style>
