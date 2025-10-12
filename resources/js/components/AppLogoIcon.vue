<script setup lang="ts">
import type { HTMLAttributes } from 'vue'

defineOptions({
    inheritAttrs: false,
})

interface Props {
    className?: HTMLAttributes['class']
}

defineProps<Props>()
</script>

<template>
  <img
    :src="
      '/images/logo/svg/protons/proton_' +
        Math.floor(1 + Math.random() * 6) +
        '.svg'
    "
    alt="Proton logo"
    :class="className"
    v-bind="$attrs"
    width="100"
    height="100"
  >
</template>
