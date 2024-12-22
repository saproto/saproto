<script setup lang="ts">
import {
    Menubar,
    MenubarContent,
    MenubarItem,
    MenubarMenu,
    MenubarSeparator,
    MenubarShortcut,
    MenubarTrigger,
} from '@/components/ui/menubar';
</script>

<template>
    <Menubar>
        <MenubarMenu class="h-25">
            <MenubarTrigger>File</MenubarTrigger>
            <MenubarContent>
                <MenubarItem>
                    New Tab

                    <MenubarShortcut>⌘T</MenubarShortcut>
                </MenubarItem>
                <MenubarItem>New Window</MenubarItem>
                <MenubarSeparator />
                <MenubarItem>Share</MenubarItem>
                <MenubarSeparator />
                <MenubarItem>Print</MenubarItem>
            </MenubarContent>
        </MenubarMenu>
    </Menubar>
</template>
