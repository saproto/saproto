<!-- resources/js/components/Menubar.vue -->
<script setup lang="ts">
import {
    Menubar,
    MenubarMenu,
    MenubarTrigger,
    MenubarContent,
    MenubarItem,
} from '@/components/ui/menubar'
</script>

<template>
    <Menubar
        class="sticky top-0 z-50 flex w-full items-center justify-between border-b border-gray-200 bg-white px-6 py-3 shadow dark:border-gray-700 dark:bg-gray-900"
    >
        <MenubarMenu>
            <MenubarTrigger>File</MenubarTrigger>
            <MenubarContent>
                <MenubarItem @click="() => console.log('New clicked')"
                    >New</MenubarItem
                >
                <MenubarItem>Open</MenubarItem>
                <MenubarItem>Save</MenubarItem>
            </MenubarContent>
        </MenubarMenu>

        <MenubarMenu>
            <MenubarTrigger>Edit</MenubarTrigger>
            <MenubarContent>
                <MenubarItem>Undo</MenubarItem>
                <MenubarItem>Redo</MenubarItem>
                <MenubarItem>Cut</MenubarItem>
            </MenubarContent>
        </MenubarMenu>
    </Menubar>
</template>
