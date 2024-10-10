<script setup lang="ts">
import { computed, useSlots } from 'vue';
import { variantStyles, hoverStyles } from '@/Enums/styles';

const slots = useSlots();

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
    initialValue?: string | number | boolean | Array<boolean>;
    modelValue?: string | number | boolean | Array<boolean>;
    placeHolder?: string;
    afterVariant?: keyof typeof variantStyles;
    beforeVariant?: keyof typeof variantStyles;
    beforeHover?: boolean;
    afterHover?: boolean;
  }>(),
  {
    name: '',
    id: undefined,
    type: 'text',
    initialValue: undefined,
    modelValue: undefined,
    placeHolder: undefined,
    afterVariant: 'info',
    beforeVariant: 'info',
  }
);

const emit = defineEmits(['update:modelValue']);

const model = computed({
  get() {
    return props.modelValue ?? props.initialValue;
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
