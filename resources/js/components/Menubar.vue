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
import { Link } from '@inertiajs/vue3'

const components: { title: string; href: string; description: string }[] = [
    {
        title: 'Alert Dialog',
        href: '/docs/components/alert-dialog',
        description:
            'A modal dialog that interrupts the user with important content and expects a response.',
    },
    {
        title: 'Hover Card',
        href: '/docs/components/hover-card',
        description:
            'For sighted users to preview content available behind a link.',
    },
    {
        title: 'Progress',
        href: '/docs/components/progress',
        description:
            'Displays an indicator showing the completion progress of a task, typically displayed as a progress bar.',
    },
    {
        title: 'Scroll-area',
        href: '/docs/components/scroll-area',
        description: 'Visually or semantically separates content.',
    },
    {
        title: 'Tabs',
        href: '/docs/components/tabs',
        description:
            'A set of layered sections of content—known as tab panels—that are displayed one at a time.',
    },
    {
        title: 'Tooltip',
        href: '/docs/components/tooltip',
        description:
            'A popup that displays information related to an element when the element receives keyboard focus or the mouse hovers over it.',
    },
]
</script>

<template>
    <nav
        class="relative z-10 mx-auto flex max-w-max flex-1 items-center justify-center"
    >
        <NavigationMenu>
            <NavigationMenuList>
                <NavigationMenuItem>
                    <NavigationMenuTrigger>For members</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul
                            class="grid gap-3 p-6 md:w-[400px] lg:w-[500px] lg:grid-cols-[minmax(0,.75fr)_minmax(0,1fr)]"
                        >
                            <li class="row-span-3">
                                <NavigationMenuLink as-child>
                                    <Link
                                        class="from-muted/50 to-muted flex h-full w-full flex-col justify-end rounded-md bg-gradient-to-b p-6 no-underline outline-none select-none focus:shadow-md"
                                        href="/"
                                    >
                                        Home
                                    </Link>

                                    <img
                                        src="https://www.reka-ui.com/logo.svg"
                                        class="h-6 w-6"
                                    />
                                    <div class="mt-4 mb-2 text-lg font-medium">
                                        shadcn/ui
                                    </div>
                                    <p
                                        class="text-muted-foreground text-sm leading-tight"
                                    >
                                        Beautifully designed components built
                                        with Radix UI and Tailwind CSS.
                                    </p>
                                </NavigationMenuLink>
                            </li>

                            <li>
                                <NavigationMenuLink as-child>
                                    <a
                                        href="/docs/introduction"
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
                                            Re-usable components built using
                                            Radix UI and Tailwind CSS.
                                        </p>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child>
                                    <a
                                        href="/docs/installation"
                                        class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                    >
                                        <div
                                            class="text-sm leading-none font-medium"
                                        >
                                            Installation
                                        </div>
                                        <p
                                            class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                        >
                                            How to install dependencies and
                                            structure your app.
                                        </p>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child>
                                    <a
                                        href="/docs/typography"
                                        class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none"
                                    >
                                        <div
                                            class="text-sm leading-none font-medium"
                                        >
                                            Typography
                                        </div>
                                        <p
                                            class="text-muted-foreground line-clamp-2 text-sm leading-snug"
                                        >
                                            Styles for headings, paragraphs,
                                            lists...etc
                                        </p>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </NavigationMenuItem>
                <NavigationMenuItem>
                    <NavigationMenuTrigger>Components</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul
                            class="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px]"
                        >
                            <li
                                v-for="component in components"
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
</template>
