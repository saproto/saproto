<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
    noAnimation?: boolean
}>()
const stats = props.data.protube
</script>
<template>
    <div class="slide">
        <h1>Your favourite song is....</h1>
        <div
            style="
                position: relative;
                width: 100%;
                aspect-ratio: 16 / 9;
                overflow: hidden;
            "
            class="youtube"
        >
            <img
                :src="stats.user.videos[0].thumbnail_url"
                style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    z-index: 1;
                "
            />
            <h2
                style="
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1;
                "
            >
                {{ stats.user.videos[0].video_title }}
            </h2>

            <iframe
                :src="`https://www.youtube.com/embed/${stats.user.videos[0].video_id}?autoplay=1`"
                style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: 0;
                    z-index: 2;
                "
            />
        </div>

        <h2 class="bottom">
            which you have played
            <span class="dynamic total">{{
                stats.user.videos[0].played_count
            }}</span>
            times!
        </h2>

        <h2 class="bottom">To complete your top 5 this year:</h2>
        <div
            v-for="(video, idx) in stats.user.videos.slice(1, 5)"
            :key="video.video_id"
            :style="`animation-delay:${noAnimation ? -6 : idx * 0.8}s`"
            class="youtube-video"
        >
            <img :src="video.thumbnail_url" />
            <span style="width: 19rem">
                <span
                    style="
                        overflow: hidden;
                        white-space: nowrap;
                        text-overflow: ellipsis;
                        width: 17rem;
                        display: inline-block;
                        margin-top: 0.2rem;
                    "
                >
                    {{ video.video_title }}
                </span>
                <br />
                Played {{ video.played_count }} times
            </span>
        </div>
    </div>
</template>

<style scoped>
.slide {
    padding: 2rem 1rem 1rem;
    background-image: linear-gradient(
        to right top,
        #d16ba5,
        #c777b9,
        #ba83ca,
        #aa8fd8,
        #9a9ae1,
        #8aa7ec,
        #79b3f4,
        #69bff8,
        #52cffe,
        #41dfff,
        #46eefa,
        #5ffbf1
    );
    text-align: center;
}

.youtube {
    corner-shape: squircle;
    border-radius: 1rem;
}

.youtube-video {
    width: 27rem;
    background: #22c1c3;
    background: linear-gradient(
        0deg,
        rgba(34, 193, 195, 1) 0%,
        rgba(253, 187, 45, 1) 100%
    );
    display: flex;
    margin-bottom: 1rem;
    corner-shape: squircle;
    border-radius: 1rem;
    overflow: hidden;
    animation-name: reveal;
    animation-duration: 1s;
    animation-fill-mode: forwards;
    transform: translateY(100vh);
}

@keyframes reveal {
    from {
        transform: translateY(100vh);
    }
    to {
        transform: translateY(0);
    }
}

.youtube-video > img {
    width: 8rem;
}

iframe {
    width: 90%;
}
.youtube {
    display: flex;
    justify-content: center;
    width: 27rem;
}
.bottom {
    margin-bottom: 1rem;
}

.total {
    color: #e01305;
}
</style>
