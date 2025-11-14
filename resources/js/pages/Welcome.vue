<script setup>
import { ref } from 'vue'

const initialPages = []
for (let i = 0; i < 193; i += 2) {
    initialPages.push({
        front: i,
        back: i + 1,
    })
}

const pages = ref(
    initialPages.map((page, index) => ({
        ...page,
        id: index,
        zIndex: initialPages.length - index,
    }))
)

const currentPage = ref(0)
const totalPages = pages.value.length

function flip(i) {
    if (i >= currentPage.value) {
        const pageToFlip = pages.value[currentPage.value]
        if (pageToFlip) {
            pageToFlip.zIndex = totalPages + 1
        }
        currentPage.value++
    } else {
        const oldCurrentPage = currentPage.value
        currentPage.value = i

        for (let j = i; j < oldCurrentPage; j++) {
            const pageToUnflip = pages.value[j]
            if (pageToUnflip) {
                pageToUnflip.zIndex = totalPages - j + 10
            }
        }
    }
}

function onTransitionEnd(page) {
    const isNowFlipped = page.id < currentPage.value

    if (isNowFlipped) {
        page.zIndex = 0
    } else {
        page.zIndex = totalPages - page.id
    }
}
</script>

<template>
    <div
        class="flex min-h-[60vh] w-full flex-col items-center justify-center space-y-6 p-4"
    >
        <!-- BOOK -->
        <div
            class="relative aspect-[3/2] w-[90vw] max-w-[900px] perspective-[1200px] md:h-[400px] md:w-[600px]"
        >
            <div
                v-for="page in pages"
                :key="page.id"
                class="absolute top-0 right-0 h-full w-1/2 origin-left cursor-pointer bg-white transition-transform duration-[900ms] [transform-style:preserve-3d]"
                :class="{
                    '[transform:rotateY(-180deg)]': page.id < currentPage,
                }"
                :style="{ zIndex: page.zIndex }"
                @click="flip(page.id)"
                @transitionend="onTransitionEnd(page)"
            >
                <!-- FRONT -->
                <div class="absolute inset-0 backface-hidden">
                    <div
                        class="font-serif text-sm leading-relaxed text-black md:text-base"
                    >
                        <img
                            v-if="page.id <= currentPage + 1"
                            :src="`/images/almanac/almanac-one/${page.front}.jpg`"
                            :alt="`Page ${page.id}`"
                        />
                    </div>
                </div>

                <!-- BACK -->
                <div class="absolute inset-0 rotate-y-180 backface-hidden">
                    <img
                        v-if="page.id <= currentPage + 1"
                        :src="`/images/almanac/almanac-one/${page.back}.jpg`"
                        :alt="`Page ${page.id}`"
                    />
                    >
                </div>
            </div>
        </div>

        <!-- NAVIGATION BUTTONS -->
        <div class="flex gap-4">
            <button
                class="rounded bg-gray-700 px-4 py-2 text-white hover:bg-gray-600 disabled:cursor-not-allowed disabled:bg-gray-500"
                :disabled="currentPage === 0"
                @click="currentPage > 0 && flip(currentPage - 1)"
            >
                Previous
            </button>
            <button
                class="rounded bg-gray-700 px-4 py-2 text-white hover:bg-gray-600 disabled:cursor-not-allowed disabled:bg-gray-500"
                :disabled="currentPage >= pages.length"
                @click="currentPage < pages.length && flip(currentPage)"
            >
                Next
            </button>
        </div>
    </div>
</template>
