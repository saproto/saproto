<script setup lang="ts">
import { computed, useSlots } from 'vue';
import moment from 'moment';
import InputWrapper from '@/Components/Input/Shared/InputWrapper.vue';
import { variantStyles } from '@/Enums/styles';

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
    type: 'date' | 'datetime-local';
    disabled?: boolean;
    required?: boolean;
    value?: string | number;
    modelValue?: string | number;
    placeHolder?: string;
    afterVariant?: keyof typeof variantStyles;
    beforeVariant?: keyof typeof variantStyles;
    beforeHover?: boolean;
    afterHover?: boolean;
  }>(),
  {
    name: undefined,
    id: undefined,
    value: undefined,
    modelValue: undefined,
    placeHolder: undefined,
    afterVariant: 'info',
    beforeVariant: 'info',
  }
);

const emit = defineEmits(['update:modelValue']);

const model = computed({
  get() {
    return moment(props.modelValue ?? props.value).format('YYYY-MM-DDTHH:mm');
  },
  set(val) {
    emit('update:modelValue', moment(val).toISOString());
  },
});
</script>

<template>
  <InputWrapper
    :before-variant="beforeVariant"
    :before-hover="beforeHover"
    :after-variant="afterVariant"
    :after-hover="afterHover !== undefined"
  >
    <input
      :id="id ?? name"
      v-model="model"
      :name="name"
      :type="type"
      :placeholder="placeHolder"
      :disabled="disabled"
      :required="required"
      :class="inputStyles()"
    />
    <template v-if="slots.before" #before>
      <slot name="before" />
    </template>
    <template v-if="slots.after" #after>
      <slot name="after" />
    </template>
  </InputWrapper>
</template>

<style scoped></style>
