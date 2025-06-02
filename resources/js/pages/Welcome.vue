<script setup lang="ts">
import { Button } from '@/components/ui/button'
import AppLayout from '@/layouts/AppLayout.vue'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
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
    <Card>
        <CardHeader>
            <CardTitle>Card Title</CardTitle>
            <CardDescription>Card Description</CardDescription>
        </CardHeader>
        <CardContent>
            Card Content
        </CardContent>
        <CardFooter>
            Card Footer
        </CardFooter>
    </Card>
</template>
