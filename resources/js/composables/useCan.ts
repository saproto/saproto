import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import type { Ref } from 'vue'
import type { Page } from '@inertiajs/core'

export function useCan() {
    const page: Page = usePage()
    const userPermissions: Ref<Array<string>> = computed(
        () => page.props.auth.user.roles
    )

    const can = (permission: string): boolean => {
        return userPermissions.value.includes(permission)
    }

    const canAny = (permissions: Array<string>): boolean => {
        return permissions.some((permission) =>
            userPermissions.value.includes(permission)
        )
    }

    const canAll = (permissions: Array<string>): boolean => {
        return permissions.every((permission) =>
            userPermissions.value.includes(permission)
        )
    }

    const canNot = (permission: string): boolean => {
        return !can(permission)
    }

    return { can, canNot, canAny, canAll }
}
