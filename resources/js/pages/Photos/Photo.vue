<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3'
import { computed, reactive, onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import { Shield, ArrowLeft, ArrowRight, Heart, Images } from 'lucide-vue-next'
import PhotoAlbumData = App.Data.PhotoAlbumData

const page = usePage()

const album = computed(() => page.props.album as PhotoAlbumData)
const albumPage = computed(() => Math.floor(state.index / 24) + 1)
const photoList = computed(() => album.value.items)
const emaildomain = computed(() => page.props.emaildomain)

const photo = computed(() => parseInt(page.props.photo as string))

const state = reactive({
    index:
        photoList.value.findIndex((p: any) => p.id === photo.value) !== -1
            ? photoList.value.findIndex((p: any) => p.id === photo.value)
            : 1,
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

function handleLikeClick() {
    router.post(route('albums::like', { photo: currentPhoto.value.id }))
}

function downloadPhoto(photoUrl: string) {
    const link = document.createElement('a')
    link.href = photoUrl
    link.download = '' // Optional: set filename like 'photo.jpg'
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
}

onMounted(() => {
    let isDownloading = false
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
            handleLikeClick()
        }
        if (e.key === 'ArrowDown') {
            if (isDownloading) return
            isDownloading = true
            downloadPhoto(currentPhoto.value.url)
            setTimeout(() => {
                isDownloading = false
            }, 1000)
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
    <div class="mx-auto max-w-4xl space-y-6 p-4">
        <div class="bg-background overflow-hidden rounded-xl border shadow">
            <div class="bg-muted flex items-center justify-end gap-2 p-3">
                <Button variant="default" class="me-auto" @click="goToAlbum">
                    <Images class="me-2 h-4 w-4" />
                    {{ album.name }}
                </Button>

                <Button
                    v-if="previousPhoto"
                    variant="ghost"
                    @click="() => goToPhotoAt(state.index - 1)"
                >
                    <ArrowLeft />
                </Button>

                <Button
                    :variant="currentPhoto.liked_by_me ? 'default' : 'outline'"
                    @click="handleLikeClick"
                >
                    <Heart class="me-2" />
                    {{ currentPhoto.likes_count }}
                </Button>

                <Button
                    v-if="currentPhoto.private"
                    variant="secondary"
                    title="Only visible to members"
                >
                    <Shield />
                </Button>

                <Button
                    v-if="nextPhoto"
                    variant="ghost"
                    @click="() => goToPhotoAt(state.index + 1)"
                >
                    <ArrowRight />
                </Button>
            </div>

            <img
                :src="currentPhoto.url"
                alt="Photo"
                class="w-full object-contain"
                style="max-height: 70vh"
            />

            <!-- Prefetch next/previous images invisibly -->
            <img
                v-if="nextPhoto"
                :src="nextPhoto.url"
                class="hidden"
                aria-hidden="true"
            />
            <img
                v-if="previousPhoto"
                :src="previousPhoto.url"
                class="hidden"
                aria-hidden="true"
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
