<script setup lang="ts">
import Menubar from '@/components/Menubar.vue'
</script>

<template>
    <div>
        <Menubar />
        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
