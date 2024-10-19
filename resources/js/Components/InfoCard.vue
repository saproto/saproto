<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    additionalClasses?: string;
  }>(),
  {
    additionalClasses: 'p-4 mx-2',
  }
);
</script>
<template>
  <div class="w-full my-2">
    <div
      :class="[props.additionalClasses ? props.additionalClasses : '']"
      class="overflow-hidden bg-back-light shadow-sm rounded-lg h-full flex flex-col"
    >
      <slot></slot>
    </div>
  </div>
</template>
