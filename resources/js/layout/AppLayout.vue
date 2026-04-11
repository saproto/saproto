<script setup lang="ts">
import AppContent from '@/components/AppContent.vue'
import Navigation from './components/Navigation.vue'
import Footer from './components/Footer.vue'
</script>

<template>
  <div class="flex min-h-screen w-full flex-col">
    <Navigation />
    <AppContent>
      <slot />
    </AppContent>
    <Footer />
  </div>
</template>
