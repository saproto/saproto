<script setup lang="ts">
import { usePage, Head, router } from '@inertiajs/vue3'
import { computed, reactive, onMounted, ref } from 'vue'
import { Button } from '@/components/ui/button'
import {
    EyeOff,
    ArrowLeft,
    ArrowRight,
    Heart,
    Images,
    Shield,
    Download,
} from 'lucide-vue-next'
import PhotoAlbumData = App.Data.PhotoAlbumData
import AuthUserData = App.Data.AuthUserData
import axios from 'axios'
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner'
import PhotoData = App.Data.PhotoData

import {
    show,
    photo as photoRoute,
    toggleLike,
} from '@/actions/App/Http/Controllers/PhotoAlbumController'
import { loginIndex } from '@/actions/App/Http/Controllers/AuthController'

const page = usePage()

const album = computed(() => page.props.album as PhotoAlbumData)
const photoList = ref(album.value.items ?? [])

const emaildomain = computed(() => page.props.emaildomain)
const user = computed(() => page.props.auth.user as AuthUserData)

const showHeart = ref(false)
const heartColor = ref('red')
let lastTapTime = 0

const photo = computed(() => parseInt(page.props.photo as string))
const state = reactive({
    index:
        photoList.value.findIndex((p: any) => p.id === photo.value) !== -1
            ? photoList.value.findIndex((p: any) => p.id === photo.value)
            : 0,
})

const currentPhoto = computed(() => photoList.value[state.index] as PhotoData)

console.log(currentPhoto.value.media)
const previousPhoto = computed(() =>
    state.index > 0 ? photoList.value[state.index - 1] : null
)
const albumPage = computed(() => Math.floor(state.index / 24) + 1)
const nextPhoto = computed(() =>
    state.index < photoList.value.length - 1
        ? photoList.value[state.index + 1]
        : null
)

const currentAlbum = computed(() => {
    return currentPhoto.value.album ?? album.value
})

let justSkipped = false
function goToPhotoAt(index: number) {
    if (isLiking || justSkipped) return
    if (index < 0 || index >= photoList.value.length) return
    justSkipped = true
    state.index = index

    // Replace history so back goes to album
    window.history.replaceState(
        { isPhotoView: true },
        '',
        photoRoute.url(album.value.id as number, {
            query: {
                photo: currentPhoto.value.id,
            },
        })
    )

    setTimeout(() => {
        justSkipped = false
    }, 100)
}

function goToAlbum(newAlbum: PhotoAlbumData, albumPage: number | null) {
    window.location.href = show.url(newAlbum.id as number, {
        query: {
            page: albumPage ?? 1,
        },
    })
}

let isLiking = false
const handleLikeClick = (index: number) => {
    if (isLiking) return
    isLiking = true
    if (!user.value) {
        window.location.href = loginIndex.url()
    }
    const photo = photoList.value[index]
    axios
        .post(toggleLike.url(photo.id))
        .then((response) => {
            photo.liked_by_me = response.data.liked_by_me as boolean
            photo.likes_count = response.data.likes_count as number
            isLiking = false
        })
        .catch(() => {
            toast('Something went wrong liking the photo', {
                description: 'Try again later',
                action: {
                    label: 'Reload',
                    onClick: () => router.reload(),
                },
            })
            isLiking = false
        })
}

let isDownloading = false
const downloadPhoto = (photo: PhotoData) => {
    if (isDownloading) return
    isDownloading = true

    const link = document.createElement('a')
    link.href = photo.url

    const parts = photo.url.split('/')

    link.download = parts.pop() ?? ''
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

    setTimeout(() => {
        isDownloading = false
    }, 1000)
}
const handlePhotoTap = () => {
    const now = new Date().getTime()
    const DOUBLE_TAP_DELAY = 400

    if (now - lastTapTime < DOUBLE_TAP_DELAY) {
        showHeart.value = true
        heartColor.value = currentPhoto.value.liked_by_me ? 'black' : 'red'
        handleLikeClick(state.index)

        setTimeout(() => {
            showHeart.value = false
        }, 400)
    }

    lastTapTime = now
}
onMounted(() => {
    window.addEventListener('keydown', (e) => {
        if (['ArrowLeft', 'ArrowRight', 'ArrowUp'].includes(e.key))
            e.preventDefault()
        if (e.key === 'ArrowLeft' && previousPhoto.value) {
            goToPhotoAt(state.index - 1)
        }
        if (e.key === 'ArrowRight' && nextPhoto.value) {
            goToPhotoAt(state.index + 1)
        }
        if (e.key === 'ArrowUp') {
            handleLikeClick(state.index)
        }
        if (e.key === 'ArrowDown') {
            downloadPhoto(currentPhoto.value)
        }
    })

    history.replaceState(
        { isPhotoView: true },
        '',
        photoRoute.url(album.value.id as number, {
            query: {
                photo: currentPhoto.value.id,
            },
        })
    )

    window.addEventListener('popstate', (e) => {
        if (e.state?.isPhotoView) {
            // Navigate to the album page based on current index
            show.url(album.value.id as number, {
                query: {
                    page: albumPage.value,
                },
            })
        }
    })
})
</script>

<template>
    <Toaster />

    <Head :title="'Album '.concat(currentAlbum.id.toString())" />

    <div class="mx-auto max-w-4xl space-y-6 p-4">
        <div class="bg-background overflow-hidden rounded-xl border shadow">
            <div
                class="bg-muted align-content-center flex w-full flex-col items-center justify-between gap-2 p-2 md:flex-row"
            >
                <div class="flex w-full flex-wrap">
                    <Button
                        v-if="currentAlbum.id !== album.id"
                        class="me-2 mb-1"
                        variant="default"
                        @click="goToAlbum(album, albumPage)"
                    >
                        <Images class="me-2 h-4 w-4" />
                        {{ album.name }}
                    </Button>
                    <Button
                        variant="default"
                        @click="goToAlbum(currentAlbum, 1)"
                    >
                        <Images class="me-2 h-4 w-4" />
                        {{ currentAlbum.name }}
                    </Button>
                </div>
                <div class="flex items-center gap-2">
                    <Button
                        v-if="currentPhoto.private"
                        disabled
                        class="bg-blue-500"
                        title="Only visible to members"
                    >
                        <EyeOff />
                    </Button>

                    <Button
                        variant="outline"
                        @click="() => downloadPhoto(currentPhoto)"
                    >
                        <Download />
                    </Button>

                    <Button
                        :disabled="!previousPhoto"
                        variant="outline"
                        class="hidden md:inline-block"
                        @click="() => goToPhotoAt(state.index - 1)"
                    >
                        <ArrowLeft />
                    </Button>

                    <Button
                        :variant="
                            currentPhoto.liked_by_me ? 'default' : 'outline'
                        "
                        @click="handleLikeClick(state.index)"
                    >
                        <Heart
                            class="me-2"
                            :fill="currentPhoto.liked_by_me ? 'red' : 'none'"
                        />
                        {{ currentPhoto.likes_count }}
                    </Button>

                    <Button
                        class="hidden md:inline-block"
                        :disabled="!nextPhoto"
                        variant="outline"
                        @click="() => goToPhotoAt(state.index + 1)"
                    >
                        <ArrowRight />
                    </Button>
                </div>
            </div>
            <div
                class="relative flex w-full items-center justify-center"
                style="max-height: 70vh"
            >
                <!-- Image -->
                <img
                    :src="currentPhoto.large_url"
                    class="w-full object-contain"
                    style="max-height: 70vh"
                    :srcset="currentPhoto.media?.srcset"
                    :alt="'Image '.concat(currentPhoto.id.toString())"
                    @click="handlePhotoTap"
                />

                <Heart
                    v-if="showHeart"
                    class="absolute h-24 w-24 animate-ping duration-[800ms]"
                    :fill="heartColor"
                    :stroke="heartColor"
                />

                <Button
                    :variant="'ghost'"
                    :disabled="!previousPhoto"
                    class="text-black-100 absolute top-1/2 left-0 flex h-full w-25 -translate-y-1/2 transform items-center justify-center p-2"
                    @click="goToPhotoAt(state.index - 1)"
                >
                    <ArrowLeft />
                </Button>

                <Button
                    :variant="'ghost'"
                    :disabled="!nextPhoto"
                    class="text-black-100 absolute top-1/2 right-0 flex h-full w-25 -translate-y-1/2 transform items-center justify-center p-2"
                    @click="goToPhotoAt(state.index + 1)"
                >
                    <ArrowRight />
                </Button>
            </div>

            <!-- Prefetch next/previous images invisibly -->
            <img
                v-if="nextPhoto"
                :src="nextPhoto.large_url"
                class="hidden"
                aria-hidden="true"
                :alt="'Image '.concat(nextPhoto.id.toString())"
            />
            <img
                v-if="previousPhoto"
                :src="previousPhoto.large_url"
                class="hidden"
                aria-hidden="true"
                :alt="'Image '.concat(previousPhoto.id.toString())"
            />
        </div>

        <div
            class="bg-muted text-muted-foreground rounded-xl border p-4 text-center text-sm shadow"
        >
            <Shield class="me-2 inline" />
            If there is a photo that you would like removed, please contact
            <a
                :href="`mailto:photos@${emaildomain || 'example.com'}`"
                class="underline"
            >
                photos@{{ emaildomain || 'example.com' }} </a
            >.
        </div>
    </div>
</template>
