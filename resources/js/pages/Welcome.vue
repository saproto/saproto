<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AppLayout from '@/layouts/AppLayout.vue'

function handleClick() {
    console.log('Button clicked!')
}

defineOptions({
    layout: AppLayout
})
</script>

<template>
    <Button @click="handleClick">Click me</Button>
</template>
