import { InertiaLinkProps } from '@inertiajs/vue3'
import type { LucideIcon } from 'lucide-vue-next'

export interface NavItem {
    title: string
    href: NonNullable<InertiaLinkProps['href']>
    icon?: LucideIcon
    isActive?: boolean
    children?: NavItem[]
    description?: string
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    menuitems: Array<App.Data.MenuItemData>
    auth: { user: App.Data.AuthUserData }
}

export interface BreadcrumbItem {
    title: string
    href: string
}
export type BreadcrumbItemType = BreadcrumbItem
