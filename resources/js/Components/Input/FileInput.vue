<script setup lang="ts">
import { computed, useSlots } from 'vue';

defineOptions({
  inheritAttrs: false,
});

const props = defineProps<{
  name?: string;
  id?: string;
  disabled?: boolean;
  required?: boolean;
  value?: string | number | boolean | Array<boolean>;
  modelValue?: string | number | boolean | Array<boolean>;
}>();

const emit = defineEmits(['update:modelValue']);

const model = computed({
  get() {
    return props.modelValue ?? props.value;
  },
  set(val) {
    emit('update:modelValue', val);
  },
});
</script>

<template>
  <input
    type="file"
    class="box-border w-full pr-2 rounded file:ring-primary hover:file:ring-primary-dark file:ring-1 file:cursor-pointer file:bg-primary hover:file:bg-primary-dark file:border-primary hover:file:border-primary-dark file:border-solid file:text-white file:rounded-s file:px-3 file:py-2 file:text-sm file:font-semibold border border-gray-500"
  />
</template>

<style scoped></style>
