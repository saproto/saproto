<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { usePage, router } from '@inertiajs/vue3'
import { computed, reactive, onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import { Shield, ArrowLeft, ArrowRight, Heart, Images } from 'lucide-vue-next'

// defineOptions({ layout: AppLayout })

const page = usePage()

const album = computed(() => page.props.album)
const albumPage = computed(() => Math.floor(state.index / 24) + 1)
const photoList = computed(() => album.value.items)
const config = computed(() => page.props.config)

const state = reactive({
    index: photoList.value.findIndex((p: any) => p.id === page.props.photo.id),
})

const currentPhoto = computed(() => photoList.value[state.index])
const previousPhoto = computed(() => (state.index > 0 ? photoList.value[state.index - 1] : null))
const nextPhoto = computed(() =>
    state.index < photoList.value.length - 1 ? photoList.value[state.index + 1] : null
)

function goToPhotoAt(index: number) {
    if (index < 0 || index >= photoList.value.length) return
    state.index = index

    // Replace history so back goes to album
    window.history.replaceState({ isPhotoView: true }, '', route('photo::view', { photo: currentPhoto.value.id }))
}

function goToAlbum() {
    window.location.href = route('photo::album::list', {
        album: album.value.id,
        page: albumPage.value ?? 1,
    })
}

function handleLikeClick() {
    // Optional: send Inertia POST or PATCH here if liking is interactive.
    router.visit(route('photo::likes', { photo: currentPhoto.value.id }))
}

onMounted(() => {
    window.addEventListener('keydown', e => {
        if (['ArrowLeft', 'ArrowRight', 'ArrowUp'].includes(e.key)) e.preventDefault()
        if (e.key === 'ArrowLeft' && previousPhoto.value) goToPhotoAt(state.index - 1)
        if (e.key === 'ArrowRight' && nextPhoto.value) goToPhotoAt(state.index + 1)
        if (e.key === 'ArrowUp') handleLikeClick()
    })

    history.replaceState({ isPhotoView: true }, '', route('photo::view', { photo: currentPhoto.value.id }))

    window.addEventListener('popstate', (e) => {
        if (e.state?.isPhotoView) {
            // Navigate to the album page based on current index
            window.location.href = route('photo::album::list', {
                album: album.id,
                page: albumPage.value,
            })
        }
    })
})
</script>

<template>
    <div class="max-w-4xl mx-auto p-4 space-y-6">
        <div class="rounded-xl shadow bg-background border overflow-hidden">
            <div class="flex justify-end items-center gap-2 bg-muted p-3">
                <Button variant="success" @click="goToAlbum" class="me-auto">
                    <Images class="me-2 h-4 w-4" />
                    {{ album.name }}
                </Button>

                <Button v-if="previousPhoto" variant="ghost" @click="() => goToPhotoAt(state.index - 1)">
                    <ArrowLeft />
                </Button>

                <Button
                    :variant="currentPhoto.liked_by_me ? 'default' : 'outline'"
                    @click="handleLikeClick"
                >
                    <Heart class="me-2" />
                    {{ currentPhoto.likes_count }}
                </Button>

                <Button v-if="currentPhoto.private" variant="secondary" title="Only visible to members">
                    <Shield />
                </Button>

                <Button v-if="nextPhoto" variant="ghost" @click="() => goToPhotoAt(state.index + 1)">
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

        <div class="rounded-xl shadow border bg-muted p-4 text-center text-sm text-muted-foreground">
            <Shield class="inline me-2" />
            If there is a photo that you would like removed, please contact
            <a :href="`mailto:photos@${config?.emaildomain || 'example.com'}`" class="underline">
                photos@{{ config?.emaildomain || 'example.com' }}
            </a>.
        </div>
    </div>
</template>
