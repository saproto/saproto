<script setup lang="ts">
import Menubar from '@/components/Menubar.vue'
import { router } from '@inertiajs/vue3'
import { SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar'
import AppSidebar from '@/components/AppSidebar.vue'
router.on('invalid', (event) => {
    event.preventDefault()
    const response = event.detail.response
    window.location.href = response.request.responseURL
})
</script>

<template>
    <div class="min-h-screen w-full">
        <Menubar />
        <SidebarProvider>
            <AppSidebar />
            <main>
                <SidebarTrigger />
                <slot />
            </main>
        </SidebarProvider>
    </div>
</template>
