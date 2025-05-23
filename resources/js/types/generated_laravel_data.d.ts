declare namespace App.Data {
    export type MenuItemData = {
        id: number
        parent: any | null
        menuname: string
        url: string | null
        page_id: number | null
        created_at: string | null
        updated_at: string | null
        order: number
        is_member_only: boolean
        children: Array<App.Data.MenuItemData>
        children_count: number | null
        page: any | null
    }
}
declare namespace App.Enums {
    export enum IsAlfredThereEnum {
        THERE = 'there',
        AWAY = 'away',
        UNKNOWN = 'unknown',
        JUR = 'jur',
        TEXT_ONLY = 'text',
    }
    export enum MembershipTypeEnum {
        PENDING = 0,
        REGULAR = 1,
        PET = 2,
        LIFELONG = 3,
        HONORARY = 4,
        DONOR = 5,
    }
}
