<script setup lang="ts">
import { router } from '@inertiajs/vue3'
router.on('invalid', (event) => {
    event.preventDefault()
    const response = event.detail.response
    window.location.href = response.request.responseURL
})
import { SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar'
import AppSidebar from '@/components/AppSidebar.vue'
</script>

<template>
  <div class="min-h-screen w-full">
    <SidebarProvider>
      <AppSidebar />
      <main>
        <SidebarTrigger />
        <slot />
      </main>
    </SidebarProvider>
  </div>
</template>
