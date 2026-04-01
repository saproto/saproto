<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AdminLayout from '@/layouts/AdminLayout.vue'

function handleClick() {
    console.log('Button clicked!')
}

defineOptions({
    layout: AdminLayout,
})
</script>

<template>
    <Button @click="handleClick"> Click me </Button>
</template>
