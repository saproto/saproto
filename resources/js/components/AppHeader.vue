<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue'
import AppLogoIcon from '@/components/AppLogoIcon.vue'
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet'
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip'
import UserMenuContent from '@/components/UserMenuContent.vue'
import { getInitials } from '@/composables/useInitials'
import { toUrl, urlIsActive } from '@/lib/utils'
import { index } from '@/routes'
import type { BreadcrumbItem, NavItem } from '@/types'
import { InertiaLinkProps, Link, usePage } from '@inertiajs/vue3'
import {
    BookOpen,
    LayoutGrid,
    Menu,
    Search,
    LucideTextQuote,
    Mail,
    ChevronDown
} from 'lucide-vue-next'
import { computed } from 'vue'
import {
    InputGroup,
    InputGroupAddon,
    InputGroupButton,
    InputGroupInput,
} from '@/components/ui/input-group'
import {
    SidebarGroup, SidebarGroupLabel,
} from '@/components/ui/sidebar'

import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible'
import FeedbackController from '@/actions/App/Http/Controllers/FeedbackController.ts'
import AchievementController from '@/actions/App/Http/Controllers/AchievementController.ts'
import StickerController from '@/actions/App/Http/Controllers/StickerController.ts'

interface Props {
    breadcrumbs?: BreadcrumbItem[]
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
})

const page = usePage()
const auth = computed(() => page.props.auth)

const isCurrentRoute = computed(
    () => (url: NonNullable<InertiaLinkProps['href']>) =>
        urlIsActive(url, page.url)
)

const activeItemStyles = computed(
    () => (url: NonNullable<InertiaLinkProps['href']>) =>
        isCurrentRoute.value(toUrl(url))
            ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100'
            : ''
)

const mainNavItems: NavItem[] = [
    {
        title: 'For members',
        // href: ProfileController.edit(),
        href: '',
        icon: LayoutGrid,
        children: [
            {
                title: 'Quotes',
                href: FeedbackController.index('quotes'),
                icon: LucideTextQuote,
            },
            {
                title: 'Good ideas',
                href: FeedbackController.index('goodIdeas'),
                icon: LucideTextQuote,
            },
            {
                title: 'Achievements',
                href: AchievementController.index(),
                icon: LucideTextQuote,
            },
            {
                title: 'Sticker tracker',
                href: StickerController.index(),
                icon: LucideTextQuote,
            },
            {
                title: 'Mental Health',
                href: index(),
                icon: LucideTextQuote,
            },
            {
                title: 'Other',
                href: index(),
                icon: LucideTextQuote,
            },
        ],
    },
    {
        title: 'Education',
        // href: ProfileController.edit(),
        href: '',
        icon: LayoutGrid,
        children: [
            {
                title: 'Study Material',
                href: index(),
                icon: LayoutGrid,
            },
            {
                title: 'Educational Committee',
                href: index(),
                icon: LayoutGrid,
            },
            {
                title: 'Educational Feedback',
                href: index(),
                icon: LayoutGrid,
            },
            {
                title: 'Books',
                href: index(),
                icon: LayoutGrid,
            },
        ],
    },
    {
        title: 'Companies',
        // href: ProfileController.edit(),
        href: '',
        icon: LayoutGrid,
        children: [
            {
                title: 'Sponsors',
                href: index(),
                icon: LayoutGrid,
            },
            {
                title: 'Job Offers',
                href: index(),
                icon: LayoutGrid,
            },
            {
                title: 'Contact for Companies',
                href: index(),
                icon: LayoutGrid,
            },
        ],
    },
]

const rightNavItems: NavItem[] = [
    {
        title: 'Wiki',
        href: 'https://wiki.proto.utwente.nl',
        icon: BookOpen,
    },
    {
        title: 'Contact',
        href: 'https://github.com/saproto/saproto',
        icon: Mail,
    },
]
</script>

<template>
    <div class="bg-background sticky top-0 z-40">
        <div class="border-sidebar-border/80 border-b">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="mr-2 h-9 w-9"
                            >
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">
                                Navigation Menu
                            </SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon
                                    class="size-6 fill-current text-black dark:text-white"
                                />
                            </SheetHeader>
                            <div
                                class="flex h-full flex-1 flex-col justify-between space-y-4 py-6"
                            >
                                <nav class="-mx-3 space-y-1">
                                    <Collapsible>
                                        <SidebarGroup>
                                            <SidebarGroupLabel asChild>
                                                <CollapsibleTrigger>
                                                    Association
                                                    <ChevronDown class="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
                                                </CollapsibleTrigger>
                                            </SidebarGroupLabel>
                                            <CollapsibleContent>
                                                <Link
                                                    class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium">
<!--                                                    :key="child.title"-->
<!--                                                    :href="child.href"-->
<!--
<!--                                                    <component-->
<!--                                                        :is="child.icon"-->
<!--                                                        v-if="child.icon"-->
<!--                                                        class="h-5 w-5"-->
<!--                                                    />-->
                                                    hallo
                                                </Link>
                                            </CollapsibleContent>
                                        </SidebarGroup>
                                    </Collapsible>
                                <Collapsible v-for="item in mainNavItems">
                                    <SidebarGroup>
                                        <SidebarGroupLabel asChild>
                                            <CollapsibleTrigger>
                                                {{ item.title }}
                                                <ChevronDown class="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
                                            </CollapsibleTrigger>
                                        </SidebarGroupLabel>
                                        <CollapsibleContent>
                                            <Link
                                                v-for="child in item.children"
                                                :key="child.title"
                                                :href="child.href"
                                                class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium"
                                            >
                                                <component
                                                    :is="child.icon"
                                                    v-if="child.icon"
                                                    class="h-5 w-5"
                                                />
                                                {{ child.title }}
                                            </Link>
                                        </CollapsibleContent>
                                    </SidebarGroup>
                                </Collapsible>
                                </nav>
                                <div class="flex flex-col space-y-4">
                                    <a
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                        :href="toUrl(item.href)"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium"
                                    >
                                        <component
                                            :is="item.icon"
                                            v-if="item.icon"
                                            class="h-5 w-5"
                                        />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link :href="index()" class="flex items-center gap-x-2">
                    <AppLogo />
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full">
                        <NavigationMenuList>
                            <NavigationMenuItem>
                                <NavigationMenuTrigger
                                    >Association</NavigationMenuTrigger
                                >
                                <NavigationMenuContent>
                                    <ul
                                        class="grid gap-3 p-6 md:w-[400px] lg:w-[500px] lg:grid-cols-[minmax(0,.75fr)_minmax(0,1fr)]"
                                    >
                                        <li class="row-span-3">
                                            <NavigationMenuLink as-child>
                                                <a
                                                    class="from-muted/50 to-muted flex h-full w-full flex-col justify-end rounded-md bg-gradient-to-b p-6 no-underline outline-none select-none focus:shadow-md"
                                                    href="/albums"
                                                >
                                                    <img
                                                        src="https://www.reka-ui.com/logo.svg"
                                                        class="h-6 w-6"
                                                    />
                                                    <div
                                                        class="mt-4 mb-2 text-lg font-medium"
                                                    >
                                                        Photos
                                                    </div>
                                                    <p
                                                        class="text-muted-foreground text-sm leading-tight"
                                                    >
                                                        Explore our events
                                                        through photos!
                                                    </p>
                                                </a>
                                            </NavigationMenuLink>
                                        </li>

                                        <li>
                                            <NavigationMenuLink as-child>
                                                <a
                                                    href="/page/about-proto"
                                                    class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                                >
                                                    <div
                                                        class="text-sm leading-none font-medium"
                                                    >
                                                        About Proto
                                                    </div>
                                                    <p
                                                        class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                                    >
                                                        What is Proto and what
                                                        do we do?
                                                    </p>
                                                </a>
                                            </NavigationMenuLink>
                                        </li>
                                        <li>
                                            <NavigationMenuLink as-child>
                                                <a
                                                    href="/page/board"
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
                                                        Meet the lovely people
                                                        running the association.
                                                    </p>
                                                </a>
                                            </NavigationMenuLink>
                                        </li>
                                        <li>
                                            <NavigationMenuLink as-child>
                                                <a
                                                    href="/committee/index"
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
                                                        See the committees that
                                                        organize all the fun
                                                        events!
                                                    </p>
                                                </a>
                                            </NavigationMenuLink>
                                        </li>
                                    </ul>
                                </NavigationMenuContent>
                            </NavigationMenuItem>
                            <NavigationMenuItem
                                v-for="(item, vIndex) in mainNavItems"
                                :key="vIndex"
                            >
                                <NavigationMenuTrigger>{{
                                    item.title
                                }}</NavigationMenuTrigger>
                                <NavigationMenuContent>
                                    <ul
                                        class="grid w-[200px] grid-cols-1 gap-3 p-4"
                                    >
                                        <li
                                            v-for="child in item.children"
                                            :key="child.title"
                                        >
                                            <NavigationMenuLink as-child>
                                                <Link
                                                    :href="child.href"
                                                    class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block rounded-md p-1 leading-none no-underline transition-colors outline-none select-none"
                                                >
                                                    <div
                                                        class="text-sm leading-none font-medium"
                                                    >
                                                        {{ child.title }}
                                                    </div>
                                                    <p
                                                        class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                                    >
                                                        {{ child.description }}
                                                    </p>
                                                </Link>
                                            </NavigationMenuLink>
                                        </li>
                                    </ul>
                                </NavigationMenuContent>
                            </NavigationMenuItem>
                            <NavigationMenuItem>
                                <NavigationMenuLink
                                    href="/events"
                                    :class="navigationMenuTriggerStyle()"
                                >
                                    Calendar
                                </NavigationMenuLink>
                            </NavigationMenuItem>
                            <NavigationMenuItem>
                                <NavigationMenuLink
                                    href="/events"
                                    :class="navigationMenuTriggerStyle()"
                                >
                                    Admin
                                </NavigationMenuLink>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <InputGroup>
                            <InputGroupInput placeholder="Type to search..." />
                            <InputGroupAddon align="inline-end">
                                <InputGroupButton variant="secondary">
                                    <Search />
                                </InputGroupButton>
                            </InputGroupAddon>
                        </InputGroup>

                        <div class="hidden space-x-1 lg:flex">
                            <template
                                v-for="item in rightNavItems"
                                :key="item.title"
                            >
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                as-child
                                                class="group h-9 w-9 cursor-pointer"
                                            >
                                                <a
                                                    :href="toUrl(item.href)"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                >
                                                    <span class="sr-only">{{
                                                        item.title
                                                    }}</span>
                                                    <component
                                                        :is="item.icon"
                                                        class="size-5 opacity-80 group-hover:opacity-100"
                                                    />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="focus-within:ring-primary relative size-10 w-auto rounded-full p-1 focus-within:ring-2"
                            >
                                <Avatar
                                    class="size-8 overflow-hidden rounded-full"
                                >
                                    <AvatarImage
                                        v-if="auth.user.avatar"
                                        :src="auth.user.avatar"
                                        :alt="auth.user.calling_name"
                                    />
                                    <AvatarFallback
                                        class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ getInitials(auth.user?.calling_name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div
            v-if="props.breadcrumbs.length > 1"
            class="border-sidebar-border/70 flex w-full border-b"
        >
            <div
                class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl"
            >
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
