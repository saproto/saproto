<script setup lang="ts">
import AppLayout from '@/layouts/AppHeaderLayout.vue'
import { index } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion'
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: index().url,
    },
]

import {
    ArchiveIcon,
    ArrowLeftIcon,
    CalendarPlusIcon,
    ClockIcon,
    ListFilterPlusIcon,
    MailCheckIcon,
    MoreHorizontalIcon,
    TagIcon,
    Trash2Icon,
} from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { ButtonGroup } from '@/components/ui/button-group'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuRadioGroup,
    DropdownMenuRadioItem,
    DropdownMenuSeparator,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { ref } from 'vue'
const label = ref('personal')
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Accordion
            type="single"
            collapsible
            class="w-full"
            default-value="item-1"
        >
            <AccordionItem value="item-1">
                <AccordionTrigger>Product Information</AccordionTrigger>
                <AccordionContent>
                    <p>
                        Our flagship product combines cutting-edge technology
                        with sleek design. Built with premium materials, it
                        offers unparalleled performance and reliability.
                    </p>
                    <p class="mt-2">
                        Key features include advanced processing capabilities,
                        and an intuitive user interface designed for both
                        beginners and experts.
                    </p>
                </AccordionContent>
            </AccordionItem>
            <AccordionItem value="item-2">
                <AccordionTrigger>Shipping Details</AccordionTrigger>
                <AccordionContent>
                    <p>
                        We offer worldwide shipping through trusted courier
                        partners. Standard delivery takes 3-5 business days,
                        while express shipping ensures delivery within 1-2
                        business days.
                    </p>
                    <p class="mt-2">
                        All orders are carefully packaged and fully insured.
                        Track your shipment in real-time through our dedicated
                        tracking portal.
                    </p>
                </AccordionContent>
            </AccordionItem>
            <AccordionItem value="item-3">
                <AccordionTrigger>Return Policy</AccordionTrigger>
                <AccordionContent>
                    <p>
                        We stand behind our products with a comprehensive 30-day
                        return policy. If you're not completely satisfied,
                        simply return the item in its original condition.
                    </p>
                    <p class="mt-2">
                        Our hassle-free return process includes free return
                        shipping and full refunds processed within 48 hours of
                        receiving the returned item.
                    </p>
                </AccordionContent>
            </AccordionItem>
        </Accordion>

        <ButtonGroup>
            <ButtonGroup class="hidden sm:flex">
                <Button variant="outline" size="icon" aria-label="Go Back">
                    <ArrowLeftIcon />
                </Button>
            </ButtonGroup>
            <ButtonGroup>
                <Button variant="outline"> Archive </Button>
                <Button variant="outline"> Report </Button>
            </ButtonGroup>
            <ButtonGroup>
                <Button variant="outline"> Snooze </Button>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button
                            variant="outline"
                            size="icon"
                            aria-label="More Options"
                        >
                            <MoreHorizontalIcon />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-52">
                        <DropdownMenuGroup>
                            <DropdownMenuItem>
                                <MailCheckIcon />
                                Mark as Read
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <ArchiveIcon />
                                Archive
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                            <DropdownMenuItem>
                                <ClockIcon />
                                Snooze
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <CalendarPlusIcon />
                                Add to Calendar
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <ListFilterPlusIcon />
                                Add to List
                            </DropdownMenuItem>
                            <DropdownMenuSub>
                                <DropdownMenuSubTrigger>
                                    <TagIcon class="mr-2 size-4" />
                                    Label As...
                                </DropdownMenuSubTrigger>
                                <DropdownMenuSubContent>
                                    <DropdownMenuRadioGroup v-model="label">
                                        <DropdownMenuRadioItem value="personal">
                                            Personal
                                        </DropdownMenuRadioItem>
                                        <DropdownMenuRadioItem value="work">
                                            Work
                                        </DropdownMenuRadioItem>
                                        <DropdownMenuRadioItem value="other">
                                            Other
                                        </DropdownMenuRadioItem>
                                    </DropdownMenuRadioGroup>
                                </DropdownMenuSubContent>
                            </DropdownMenuSub>
                        </DropdownMenuGroup>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                            <DropdownMenuItem variant="destructive">
                                <Trash2Icon />
                                Trash
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
            </ButtonGroup>
        </ButtonGroup>
    </AppLayout>
</template>
