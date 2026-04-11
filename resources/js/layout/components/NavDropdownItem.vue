
<script setup lang="ts">
defineProps<{
  href: string
  target?: string
}>()
</script>

<template>
  <li>
    <a
      :href="href"
      :target="target"
      class="block px-4 py-1 text-card-foreground whitespace-nowrap hover:bg-accent no-underline"
    >
      <slot />
    </a>
  </li>
</template>
