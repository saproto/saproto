<script setup lang="ts">
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
