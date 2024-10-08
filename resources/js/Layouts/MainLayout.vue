<script setup lang="ts">
// import { usePage } from '@inertiajs/vue3';
// import { computed } from 'vue';
import NavBar from '@/Layouts/NavBar.vue';
import WebsiteFooter from '@/Layouts/WebsiteFooter.vue';
</script>

<template>
  <div class="flex flex-col bg-back-light text-front min-h-screen">
    <NavBar />
    <main role="main" class="w-full p-4 mx-auto mb-auto lg:w-10/12 xl:w-8/12">
      <slot />
    </main>
    <WebsiteFooter />
  </div>
</template>
