<script setup lang="ts">
import { computed, useSlots } from 'vue';

const slots = useSlots();

const variantStyles = {
  primary: 'bg-primary border-primary',
  secondary: 'bg-secondary border-secondary',
  success: 'bg-success border-success',
  info: 'bg-info border-info',
  warning: 'bg-warning border-warning',
  danger: 'bg-danger border-danger',
  dark: 'bg-dark border-dark',
  light: 'bg-light border-light',
};

const hoverStyles = {
  primary: 'hover:bg-primary-dark hover:border-primary-dark',
  secondary: 'hover:bg-secondary-dark hover:border-secondary-dark',
  success: 'hover:bg-success-dark hover:border-success-dark',
  info: 'hover:bg-info-dark hover:border-info-dark',
  warning: 'hover:bg-warning-dark hover:border-warning-dark',
  danger: 'hover:bg-danger-dark hover:border-danger-dark',
  dark: 'hover:bg-dark-dark hover:border-dark-dark',
  light: 'hover:bg-light-dark hover:border-light-dark',
};

const inputStyles = () => {
  let styles =
    'focus:ring-0 focus:outline-none focus:border-blue-600 leading-tight w-full text-front px-3 py-2 bg-back disabled:bg-back-light';
  styles += slots.before ? ' border-s-0' : ' rounded-s';
  styles += slots.after ? ' border-e-0' : ' rounded-e';
  return styles;
};

defineOptions({
  inheritAttrs: false,
});

const props = withDefaults(
  defineProps<{
    name?: string;
    id?: string;
    type?: 'text' | 'number' | 'datetime-local' | 'select' | 'checkbox' | 'file';
    disabled?: boolean;
    required?: boolean;
    value?: string | number | boolean | Array<boolean>;
    modelValue?: string | number | boolean | Array<boolean>;
    placeHolder?: string;
    afterVariant?: string;
    beforeVariant?: string;
    beforeHover?: boolean;
    afterHover?: boolean;
  }>(),
  {
    name: null,
    id: null,
    type: 'text',
    value: null,
    modelValue: null,
    placeHolder: null,
    afterVariant: 'info',
    beforeVariant: 'info',
  }
);

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
  <div class="shadow rounded flex items-center m-0 p-0 ring-blue-600 focus-within:ring-1">
    <div class="order-2 flex-grow peer">
      <select
        v-if="type === 'select'"
        :id="id ?? name"
        v-model="model"
        :name="name"
        :value="value"
        :disabled="disabled"
        :required="required"
        :class="inputStyles()"
      >
        <slot />
      </select>
      <input
        v-else
        :id="id ?? name"
        v-model="model"
        :name="name"
        :type="type ?? 'text'"
        :placeholder="placeHolder"
        :disabled="disabled"
        :required="required"
        :class="inputStyles()"
      />
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
