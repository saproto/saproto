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
} from 'lucide-vue-next'
import PhotoAlbumData = App.Data.PhotoAlbumData
import AuthUserData = App.Data.AuthUserData
import axios from 'axios'
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner'

const page = usePage()

const album = computed(() => page.props.album as PhotoAlbumData)
const albumPage = computed(() => Math.floor(state.index / 24) + 1)

const photoList = ref(album.value.items)

const emaildomain = computed(() => page.props.emaildomain)
const user = computed(() => page.props.auth.user as AuthUserData)

const photo = computed(() => parseInt(page.props.photo as string))
const state = reactive({
    index:
        photoList.value.findIndex((p: any) => p.id === photo.value) !== -1
            ? photoList.value.findIndex((p: any) => p.id === photo.value)
            : 0,
})

const currentPhoto = computed(() => photoList.value[state.index])
const previousPhoto = computed(() =>
    state.index > 0 ? photoList.value[state.index - 1] : null
)
const nextPhoto = computed(() =>
    state.index < photoList.value.length - 1
        ? photoList.value[state.index + 1]
        : null
)

function goToPhotoAt(index: number) {
    if (isLiking) return
    if (index < 0 || index >= photoList.value.length) return
    state.index = index

    // Replace history so back goes to album
    window.history.replaceState(
        { isPhotoView: true },
        '',
        route('albums::album::show', {
            album: album.value.id,
            photo: currentPhoto.value.id,
        })
    )
}

function goToAlbum() {
    window.location.href = route('albums::album::list', {
        album: album.value.id,
        page: albumPage.value ?? 1,
    })
}

let isLiking = false
const handleLikeClick = (index: number) => {
    if (isLiking) return
    isLiking = true
    if (!user.value) {
        window.location.href = route('login::show')
    }
    const photo = photoList.value[index]
    axios
        .post(route('albums::like', { photo: photo.id }))
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
const downloadPhoto = (photoUrl: string) => {
    if (isDownloading) return
    isDownloading = true

    const link = document.createElement('a')
    link.href = photoUrl
    link.download = ''
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

    setTimeout(() => {
        isDownloading = false
    }, 1000)
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
            downloadPhoto(currentPhoto.value.url)
        }
    })

    history.replaceState(
        { isPhotoView: true },
        '',
        route('albums::album::show', {
            album: album.value.id,
            photo: currentPhoto.value.id,
        })
    )

    window.addEventListener('popstate', (e) => {
        if (e.state?.isPhotoView) {
            // Navigate to the album page based on current index
            window.location.href = route('albums::album::list', {
                album: album.value.id,
                page: albumPage.value,
            })
        }
    })
})
</script>

<template>
    <Toaster />

    <Head :title="'Album '.concat(album.id.toString())" />

    <div class="mx-auto max-w-4xl space-y-6 p-4">
        <div class="bg-background overflow-hidden rounded-xl border shadow">
            <div class="bg-muted flex items-center justify-end gap-2 p-3">
                <Button variant="default" class="me-auto" @click="goToAlbum">
                    <Images class="me-2 h-4 w-4" />
                    {{ album.name }}
                </Button>

                <Button
                    v-if="currentPhoto.private"
                    disabled
                    class="bg-blue-500"
                    title="Only visible to members"
                >
                    <EyeOff />
                </Button>

                <Button
                    :disabled="!previousPhoto"
                    variant="outline"
                    @click="() => goToPhotoAt(state.index - 1)"
                >
                    <ArrowLeft />
                </Button>

                <Button
                    :variant="currentPhoto.liked_by_me ? 'default' : 'outline'"
                    @click="handleLikeClick(state.index)"
                >
                    <Heart class="me-2" />
                    {{ currentPhoto.likes_count }}
                </Button>

                <Button
                    :disabled="!nextPhoto"
                    variant="outline"
                    @click="() => goToPhotoAt(state.index + 1)"
                >
                    <ArrowRight />
                </Button>
            </div>

            <img
                :src="currentPhoto.large_url"
                class="w-full object-contain"
                style="max-height: 70vh"
                :alt="'Image '.concat(currentPhoto.id.toString())"
            />

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
