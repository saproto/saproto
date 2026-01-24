<script setup lang="ts">
import type { PinInputInputProps } from 'reka-ui'
import type { HTMLAttributes } from 'vue'
import { reactiveOmit } from '@vueuse/core'
import { PinInputInput, useForwardProps } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps<
    PinInputInputProps & { class?: HTMLAttributes['class'] }
>()

const delegatedProps = reactiveOmit(props, 'class')

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
  <PinInputInput
    v-bind="forwardedProps"
    :class="
      cn(
        'focus:ring-ring border-input relative flex h-9 w-9 items-center justify-center border-y border-r text-center text-sm transition-all first:rounded-l-md first:border-l last:rounded-r-md focus:relative focus:z-10 focus:ring-2 focus:outline-none',
        props.class
      )
    "
  />
</template>
