<script setup lang="ts">
import AppContent from '@/components/AppContent.vue'
// import AppHeader from '@/components/AppHeader.vue'
import AppShell from '@/components/AppShell.vue'
import Footer from '@/components/Footer.vue'
import Test from '@/components/Test.vue'
import type { BreadcrumbItemType } from '@/types'

interface Props {
    breadcrumbs?: BreadcrumbItemType[]
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
})
</script>

<template>
  <AppShell class="flex-col">
    <!-- <AppHeader :breadcrumbs="breadcrumbs" /> -->
    <Test />
    <AppContent>
      <slot />
    </AppContent>
    <Footer />
  </AppShell>
</template>
