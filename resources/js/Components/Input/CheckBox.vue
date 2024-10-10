<script setup lang="ts">
import { computed } from 'vue';

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
  <div class="flex items-center space-x-2 mb-4">
    <input
      :id="id ?? name"
      v-model="model"
      class="rounded bg-back border-none ring-1 ring-front ring-opacity-20 checked:bg-primary hover:bg-back-light checked:hover:bg-primary-dark"
      :value="value"
      type="checkbox"
      :name="name"
      :disabled="disabled"
      :required="required"
    />
    <label class="text-sm font-bold" :for="id ?? name">
      <slot />
    </label>
  </div>
</template>
<style scoped></style>
