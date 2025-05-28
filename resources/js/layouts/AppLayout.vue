<script setup lang="ts">
import Menubar from '@/components/Menubar.vue'
import { router } from '@inertiajs/vue3'
router.on('invalid', (event) => {
    event.preventDefault()
    const response = event.detail.response
    window.location.href = response.request.responseURL
})
</script>

<template>
    <div class="min-h-screen w-full">
        <Menubar />
            <main>
                <slot />
            </main>
    </div>
</template>
