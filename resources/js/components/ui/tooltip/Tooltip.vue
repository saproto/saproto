<script setup lang="ts">
import {
    TooltipRoot,
    type TooltipRootEmits,
    type TooltipRootProps,
    useForwardPropsEmits,
} from 'reka-ui'

const props = defineProps<TooltipRootProps>()
const emits = defineEmits<TooltipRootEmits>()

const forwarded = useForwardPropsEmits(props, emits) as Record<string, any> as Record<string, any>
</script>

<template>
    <TooltipRoot data-slot="tooltip" v-bind="forwarded">
        <slot />
    </TooltipRoot>
</template>
