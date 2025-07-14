<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AppLayout from '@/layouts/AppLayout.vue'

function handleClick() {
    console.log('Button clicked!')
}

defineOptions({
    layout: AppLayout,
})
import { usePage } from '@inertiajs/vue3'
const page = usePage()
</script>

<template>
    {{ page.props }}
    <Button @click="handleClick">Click me</Button>
</template>
