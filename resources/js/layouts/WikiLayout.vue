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
        <div class=" flex w-full items-center justify-center">
        <div class="lg:w-6/12 w-full bg-red-50 ">
            <img
            height="111.5"
            width="200.7"
            src="/images/logo/regular.png"
            alt="inverse proto logo"
            class="p-8"
        /> </div>
        </div>
        <main>
            <slot />
        </main>
    </div>
</template>
