<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { reactiveOmit } from '@vueuse/core'
import { DialogTitle, type DialogTitleProps } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps<
    DialogTitleProps & { class?: HTMLAttributes['class'] }
>()

const delegatedProps = reactiveOmit(props, 'class')
</script>

<template>
    <DialogTitle
        :class="cn('text-foreground text-lg font-semibold', props.class)"
        v-bind="delegatedProps"
    >
        <slot />
    </DialogTitle>
</template>
