<script setup lang="ts">
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import {
    InputGroup,
    InputGroupAddon,
    InputGroupButton,
    InputGroupInput,
} from '@/components/ui/input-group'
import { computed } from 'vue'
import AuthUserData = App.Data.AuthUserData
import {
    Menubar,
    MenubarContent,
    MenubarItem,
    MenubarMenu,
    MenubarSeparator,
    MenubarShortcut,
    MenubarTrigger,
} from '@/components/ui/menubar'
const page = usePage()
const user = computed(() => page.props.auth.user as AuthUserData)

const form = useForm({
    query: '',
})

const companies: { title: string; href: string; description?: string }[] = [
    {
        title: 'Our sponsors',
        href: route('companies::index'),
        description:
            'The companies that support us financially and help us grow',
    },
    {
        title: 'Job offers',
        href: route('joboffers::index'),
        description: 'The latest job offers from our sponsors',
    },
    {
        title: 'Contact for companies',
        href: route('page::show', { slug: 'for-companies' }),
        description:
            'Get in touch for collaboration or sponsorship opportunities',
    },
]

const formembers: { title: string; href: string; description?: string }[] = [
    {
        title: 'Our sponsors',
        href: route('companies::index'),
        description:
            'The companies that support us financially and help us grow',
    },
    {
        title: 'Job offers',
        href: route('joboffers::index'),
        description: 'The latest job offers from our sponsors',
    },
    {
        title: 'Contact for companies',
        href: route('page::show', { slug: 'for-companies' }),
        description:
            'Get in touch for collaboration or sponsorship opportunities',
    },
]
</script>

<template>
    <div
        class="justify-content-center relative z-10 mx-auto flex w-full flex-1 items-center justify-between border p-1"
    >
        <p>S.A. Proto</p>
        <nav>
            <NavigationMenu>
                <NavigationMenuList>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger
                            >Association</NavigationMenuTrigger
                        >
                        <NavigationMenuContent>
                            <ul
                                class="grid gap-3 p-6 md:w-[400px] lg:w-[500px] lg:grid-cols-[minmax(0,.75fr)_minmax(0,1fr)]"
                            >
                                <li class="row-span-2">
                                    <NavigationMenuLink as-child>
                                        <Link
                                            class="from-muted/50 to-muted flex h-full w-full flex-col justify-end rounded-md bg-gradient-to-b p-6 no-underline outline-none select-none focus:shadow-md"
                                            :href="route('albums::index')"
                                        >
                                            <!--                                        todo: fetch random album cover and display here-->
                                            <!--                                    <img-->
                                            <!--                                        src="https://www.reka-ui.com/logo.svg"-->
                                            <!--                                        class="h-6 w-6"-->
                                            <!--                                    />-->
                                            <div
                                                class="mt-4 mb-2 text-lg font-medium"
                                            >
                                                Photos
                                            </div>
                                        </Link>
                                    </NavigationMenuLink>
                                </li>

                                <li>
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="
                                                route('page::show', {
                                                    slug: 'about-proto',
                                                })
                                            "
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div
                                                class="text-sm leading-none font-medium"
                                            >
                                                Introduction
                                            </div>
                                            <p
                                                class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                            >
                                                What is Proto?
                                            </p>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                                <li>
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="
                                                route('page::show', {
                                                    slug: 'board',
                                                })
                                            "
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div
                                                class="text-sm leading-none font-medium"
                                            >
                                                Board
                                            </div>
                                            <p
                                                class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                            >
                                                The lovely people currently
                                                running the association
                                            </p>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                                <li>
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="route('event::index')"
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div
                                                class="text-sm leading-none font-medium"
                                            >
                                                Calendar
                                            </div>
                                            <p
                                                class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                            >
                                                See our upcoming activities!
                                            </p>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                                <li>
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="route('committee::index')"
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div
                                                class="text-sm leading-none font-medium"
                                            >
                                                Committees
                                            </div>
                                            <p
                                                class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                            >
                                                Discover the committees that
                                                make Proto great
                                            </p>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                            </ul>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger
                            >For members</NavigationMenuTrigger
                        >
                        <NavigationMenuContent>
                            <ul
                                class="grid w-[200px] gap-3 p-1 md:w-[150px] lg:w-[200px]"
                            >
                                <li
                                    v-for="item in formembers"
                                    :key="item.title"
                                >
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="item.href"
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div class="text-sm leading-none">
                                                {{ item.title }}
                                            </div>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                            </ul>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger>Companies</NavigationMenuTrigger>
                        <NavigationMenuContent>
                            <ul
                                class="grid w-[400px] gap-3 p-4 md:w-[300px] md:grid-cols-1 lg:w-[400px]"
                            >
                                <li
                                    v-for="component in companies"
                                    :key="component.title"
                                >
                                    <NavigationMenuLink as-child>
                                        <a
                                            :href="component.href"
                                            class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                        >
                                            <div
                                                class="text-sm leading-none font-medium"
                                            >
                                                {{ component.title }}
                                            </div>
                                            <p
                                                class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                            >
                                                {{ component.description }}
                                            </p>
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                            </ul>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                    <NavigationMenuItem>
                        <NavigationMenuLink
                            href="https://wiki.proto.utwente.nl"
                            :class="navigationMenuTriggerStyle()"
                        >
                            Wiki
                        </NavigationMenuLink>
                    </NavigationMenuItem>
                </NavigationMenuList>
            </NavigationMenu>
        </nav>
        <div class="flex items-center gap-4">
            <Menubar>
                <MenubarMenu>
                    <MenubarTrigger class="bg-red-500"> Files </MenubarTrigger>
                    <MenubarContent>
                        <MenubarItem>
                            New Tab <MenubarShortcut>⌘T</MenubarShortcut>
                        </MenubarItem>
                        <MenubarItem>New Window</MenubarItem>
                        <MenubarSeparator />
                        <MenubarItem>Share</MenubarItem>
                        <MenubarSeparator />
                        <MenubarItem>Print</MenubarItem>
                    </MenubarContent>
                </MenubarMenu>
            </Menubar>
            <img
                :src="user.photo"
                class="text-foreground bg-secondary inline-flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full object-cover object-center text-xs font-normal select-none"
                :alt="user.calling_name"
            />
            <form @submit.prevent="form.get(route('search::get'))">
                <InputGroup>
                    <InputGroupInput
                        v-model="form.query"
                        placeholder="Type to search..."
                    />
                    <InputGroupAddon align="inline-end">
                        <InputGroupButton variant="secondary">
                            <Search />
                        </InputGroupButton>
                    </InputGroupAddon>
                </InputGroup>
            </form>
        </div>
    </div>
</template>
