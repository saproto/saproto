<script setup lang="ts">
import { ref } from 'vue'
import type { Component } from 'vue'
import html2canvas from 'html2canvas'
import TotalSpent from '@/pages/Wrapped/Slides/TotalSpent.vue'
import MostBought from '@/pages/Wrapped/Slides/MostBought.vue'
import Calories from '@/pages/Wrapped/Slides/Calories.vue'
import Drinks from '@/pages/Wrapped/Slides/Drinks.vue'
import WillToLive from '@/pages/Wrapped/Slides/WillToLive.vue'
import DaysAtProto from '@/pages/Wrapped/Slides/DaysAtProto.vue'
import Activities from '@/pages/Wrapped/Slides/Activities.vue'
import KoenkertCatagory from '../Slides/KoenkertCatagory.vue'
import { useSwipe } from '@vueuse/core'
import { statsType } from '@/pages/Wrapped/types.ts'
import { ArrowUp } from 'lucide-vue-next'
import domtoimage from 'dom-to-image';

const props = defineProps<{
    data: statsType
}>()

const stats = props.data
const currentSlide = ref(0)
const touched = ref(false)
const held = ref(false)
let touchTimeout: number
const transition = ref('slide-left')
const slide = ref<HTMLDivElement | null>(null)

type SlideComponent =
    | typeof TotalSpent
    | typeof MostBought
    | typeof Calories
    | typeof Drinks
    | typeof WillToLive
    | typeof DaysAtProto
    | typeof Activities
    | typeof KoenkertCatagory

const slideElement = ref<SlideComponent>()
const sharing = ref(false)

let allSlides: Array<[Component, number] | true> = [
    [TotalSpent, 10],
    [MostBought, 10],
    [Calories, 10],
    stats.drinks.amount <= 0 || [Drinks, 10],
    stats.willToLives.amount <= 0 || [WillToLive, 10],
    [DaysAtProto, 10],
    stats.activities.amount <= 0 || [Activities, 10],
    [KoenkertCatagory, 10],
]

const slides = allSlides.filter((x) => x !== true)

const shareSlide = async () => {
    if (!slide.value) return
    sharing.value = true
    setTimeout(async () => {
        try {
            if (!slide.value) return
            domtoimage.toBlob(slide.value)
                .then(async (blob) => {
                if (!blob) return
                if (navigator.share) {
                    const year = new Date().getFullYear()
                    const imgFile = new File(
                        [blob],
                        `ProtoWrapped${year}.png`,
                        { type: 'image/png' }
                    )
                    await navigator.share({
                        // title: 'OmNomComWrapped 2022',
                        // text: 'Look at my OmNomCom Wrapped of 2022! Find yours at wrapped.omnomcom.nl',
                        files: [imgFile],
                        // url: window.location.href,
                    })
                } else {
                    const dataUrl = URL.createObjectURL(blob)
                    const link = document.createElement('a')
                    const year = new Date().getFullYear()
                    link.download = `ProtoWrapped${year}.png`
                    link.href = dataUrl
                    link.click()
                }
            })
        } catch (e) {
            console.log(e)
        }
        setTimeout(() => {
            sharing.value = false
        }, 0)
    }, 0)
}
const nextSlide = () => {
    if (held.value) {
        return
    }
    transition.value = 'slide-left'
    if (currentSlide.value === slides.length - 1) return
    currentSlide.value += 1
}

const prevSlide = () => {
    if (held.value) {
        return
    }
    transition.value = 'slide-right'
    if (currentSlide.value === 0) return
    currentSlide.value -= 1
}

currentSlide.value = 0
// slides[currentSlide.value][0];
window.addEventListener('keydown', (e) => {
    switch (e.code) {
        case 'ArrowLeft':
            prevSlide()
            break
        case 'ArrowRight':
            nextSlide()
            break
    }
})

const slideClick = (e: MouseEvent) => {
    const target = e.currentTarget as HTMLElement
    const bounds = target.getBoundingClientRect()
    const middle = bounds.left + bounds.width / 2
    if (e.pageX < middle) {
        prevSlide()
    } else {
        nextSlide()
    }
}

const pageClick = (e: MouseEvent) => {
    const target = e.currentTarget as HTMLElement
    if (target !== e.target) return
    const bounds = target.getBoundingClientRect()
    const middle = bounds.left + bounds.width / 2
    if (e.pageX < middle) {
        prevSlide()
    } else {
        nextSlide()
    }
}

const touchEvent = (state: boolean) => {
    touched.value = state
    if (state) {
        clearTimeout(touchTimeout)
        touchTimeout = setTimeout(() => {
            held.value = true
        }, 100)
    } else {
        clearTimeout(touchTimeout)
        touchTimeout = setTimeout(() => {
            held.value = false
        }, 0)
    }
}

const startTouch = () => {
    touchEvent(true)
}

const stopTouch = () => {
    touchEvent(false)
}
// @ts-expect-error some weird error on the wrong type of the slideElement component
const { lengthX } = useSwipe(slideElement, {
    passive: true,
    onSwipeStart() {
        touched.value = true
        slideElement.value?.$el.classList.remove('slide-transition')
    },
    onSwipe() {
        if (!slideElement.value) return
        const el = slideElement.value.$el
        const parent = slide.value
        if (!parent) return
        let moveVal = -lengthX.value
        let rotateVal =
            (-lengthX.value / parent.getBoundingClientRect()?.width) * 40
        if (currentSlide.value === 0) {
            moveVal = Math.min(0, moveVal)
            rotateVal = Math.min(40, rotateVal)
        } else if (currentSlide.value === slides.length - 1) {
            moveVal = Math.max(0, moveVal)
            rotateVal = Math.max(-40, rotateVal)
        }

        if (moveVal === 0) {
            el.style.transform = `rotateY(${rotateVal}deg)`
        } else {
            el.style.transform = `translateX(${moveVal}px)`
        }
    },
    onSwipeEnd() {
        if (!slide.value) return
        const el = slideElement.value?.$el
        const slideWidth = slide.value.getBoundingClientRect().width / 2
        el.classList.add('slide-transition')
        touched.value = false
        if (lengthX.value < -slideWidth && currentSlide.value !== 0) {
            prevSlide()
        } else if (
            lengthX.value > slideWidth &&
            currentSlide.value !== slides.length - 1
        ) {
            nextSlide()
        } else {
            el.style.transform = ''
        }
    },
})
</script>

<template>
    <div id="slideshow" @click="pageClick">
        <div>
            <h1>
                {{ $page.props.auth.user.calling_name }}'s
                <span class="omnomcom">Proto</span> Wrapped
            </h1>
        </div>

        <div id="progress">
            <div v-for="(otherSlide, i) in slides" :key="i" class="bar">
                <div
                    class="progress-bar"
                    :class="{
                        playing: currentSlide === i && !touched,
                        ended: currentSlide > i,
                        tostart: currentSlide < i,
                    }"
                    :style="{ animationDuration: otherSlide[1] + 's' }"
                    @animationend="nextSlide()"
                />
            </div>
        </div>

        <div id="slide-holder" ref="slide">
            <Transition :name="transition">
                <component
                    :is="slides[currentSlide][0]"
                    ref="slideElement"
                    class="slide"
                    :data="data"
                    :time="slides[currentSlide][1]"
                    :no-animation="sharing"
                    @click="slideClick"
                    @mousedown="startTouch"
                    @mouseup="stopTouch"
                />
            </Transition>
        </div>
        <button id="share" @click="shareSlide()">
            <ArrowUp />
            Share this slide
        </button>
    </div>
</template>

<style scoped>
#share {
    display: flex;
    justify-content: center;
    align-items: center;
}
#slideshow {
    position: fixed;
    width: 100vw;
    height: 100svh;
    top: 0;
    left: 0;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    gap: 0.5em;
    padding-bottom: 0.5em;
}

#prev,
#next {
    position: fixed;
    opacity: 0.2;
    top: 0;
    height: 100svh;
    width: 50vw;
}

#prev {
    left: 0;
}

#next {
    right: 0;
}

#progress {
    height: 0.5em;
    width: min(calc(87vw), calc(calc(87svh) * 0.56));
    display: flex;
    align-items: center;
}

.bar {
    flex-grow: 1;
    height: 0.3em;
    background: grey;
    margin: 0 0.2em;
    border-radius: 0.1em;
}

.progress-bar {
    content: '';
    display: block;
    background: white;
    border-radius: 0.1em;
    height: 0.3em;
    width: 0;
    animation: progress-bar 10s linear forwards;
    animation-play-state: paused;
}

.progress-bar.playing {
    animation-play-state: running;
}

.progress-bar.ended {
    animation: none;
    width: 100%;
}

.progress-bar.tostart {
    animation: none;
    width: 0;
}

@keyframes progress-bar {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

#slide-holder {
    width: min(calc(87vw), calc(calc(87svh) * 0.56));
    aspect-ratio: 0.56;
    perspective: 100rem;
    perspective-origin: 50vw 50svh;
}

.slide-transition {
    transition: transform 0.3s ease;
}

.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 0.3s ease;
}

.slide-left-enter-from,
.slide-right-leave-to {
    transform: translateX(calc(100vw)) !important;
}

.slide-left-leave-to,
.slide-right-enter-from {
    transform: translateX(calc(-100vw)) !important;
}
</style>
