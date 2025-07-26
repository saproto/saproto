<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AppLayout from '@/layouts/AppLayout.vue'

function handleClick() {
    console.log('Button clicked!')
}

defineOptions({
    layout: AppLayout,
})
import { Head, usePage } from '@inertiajs/vue3'
const page = usePage()
</script>

<template>
    <Head title="Welcome" />

    {{ page.props }}
    <Button @click="handleClick">Click me</Button>
</template>
