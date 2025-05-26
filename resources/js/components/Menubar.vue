<script setup lang="ts">
import { createReusableTemplate, useMediaQuery } from '@vueuse/core'
import { computed, ref } from 'vue'
import { Button } from '@/components/ui/button'
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer'

import {
    Menubar,
    MenubarMenu,
    MenubarTrigger,
    MenubarContent,
    MenubarItem,
} from '@/components/ui/menubar'

import { Menu } from 'lucide-vue-next'
import { Link, usePage } from '@inertiajs/vue3'

const isDesktop = useMediaQuery('(min-width: 768px)')
const [UseTemplate, GridForm] = createReusableTemplate()

const isOpen = ref(false)
const page = usePage()
const menuitems = computed(() => page.props.menuitems)

import { useCan } from '@/composables/useCan'
const {can} = useCan()
</script>

<template>
    <!-- Menu Items -->
    <UseTemplate>
        <MenubarMenu v-for="menuitem in menuitems" :key="menuitem.id">
            <MenubarTrigger>{{ menuitem.menuname }}</MenubarTrigger>
            <MenubarContent class="w-full">
                <MenubarItem v-for="child in menuitem.children" :key="child.id" class="w-full">
                    {{ child.menuname }}
                </MenubarItem>
            </MenubarContent>
        </MenubarMenu>

        <MenubarMenu>
            <Link :href="route('admin')">
                <MenubarTrigger>Admin</MenubarTrigger>
            </Link>
        </MenubarMenu>
    </UseTemplate>

    <!-- Menubar -->
    <Menubar
        class="sticky top-0 z-50 justify-end md:justify-start flex w-full items-center border-b border-gray-200 bg-white px-6 py-3 shadow dark:border-gray-700 dark:bg-gray-900"
    >
        <!-- Show full menu on desktop -->
        <GridForm v-if="isDesktop" />

        <!-- Drawer hamburger on mobile -->
        <Drawer v-else v-model:open="isOpen">
            <MenubarMenu>
                <DrawerTrigger as-child>
                    <MenubarTrigger class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md">
                        <Menu class="w-5 h-5" />
                    </MenubarTrigger>
                </DrawerTrigger>
            </MenubarMenu>
            <DrawerContent>
                <DrawerHeader class="text-left">
                    <DrawerTitle>Navigation</DrawerTitle>
                    <DrawerDescription>
                    </DrawerDescription>
                </DrawerHeader>

                <GridForm />

                <DrawerFooter class="pt-2">
                    <DrawerClose as-child>
                        <Button variant="outline">Close</Button>
                    </DrawerClose>
                </DrawerFooter>
            </DrawerContent>
        </Drawer>
    </Menubar>
</template>
