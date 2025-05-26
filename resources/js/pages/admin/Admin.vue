<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AdminLayout from '@/layouts/AdminLayout.vue'

function handleClick() {
    console.log('Button clicked!')
}

defineOptions({
    layout: AdminLayout,
})
import { usePage } from '@inertiajs/vue3'
// import { computed } from 'vue'
const page = usePage()
// const user = computed(() => page.props.auth.user)
</script>

<template>
    <Button @click="handleClick">Click me</Button>
</template>
