import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'
import { InertiaLinkProps } from '@inertiajs/vue3'
export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string
) {
    return toUrl(urlToCheck) === currentUrl
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url
}
