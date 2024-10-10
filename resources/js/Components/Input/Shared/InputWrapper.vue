<script setup lang="ts">
import { useSlots } from 'vue';
import { variantStyles, hoverStyles } from '@/Enums/styles';

const slots = useSlots();

defineOptions({
  inheritAttrs: false,
});

withDefaults(
  defineProps<{
    afterVariant?: keyof typeof variantStyles;
    beforeVariant?: keyof typeof variantStyles;
    beforeHover?: boolean;
    afterHover?: boolean;
  }>(),
  {
    afterVariant: 'primary',
    beforeVariant: 'info',
    beforeHover: false,
    afterHover: false,
  }
);
</script>

<template>
  <div class="shadow rounded flex items-center m-0 p-0 ring-blue-600 focus-within:ring-1">
    <div class="order-2 flex-grow peer">
      <slot />
    </div>
    <div
      v-if="slots.before"
      class="order-1 self-stretch text-white flex items-center rounded-s border-t border-l border-b peer-focus-within:border-blue-600"
      :class="variantStyles[beforeVariant] + ' ' + (beforeHover ? hoverStyles[beforeVariant] : '')"
    >
      <slot name="before" />
    </div>
    <div
      v-if="slots.after"
      class="order-3 self-stretch text-white flex items-center rounded-e border-t border-r border-b peer-focus-within:border-blue-600"
      :class="variantStyles[afterVariant] + ' ' + (afterHover ? hoverStyles[afterVariant] : '')"
    >
      <slot name="after" />
    </div>
  </div>
</template>

<style scoped></style>
