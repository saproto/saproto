declare namespace App.Data {
export type AuthUserData = {
id: number;
calling_name: string;
roles: Array<string>;
is_member: boolean;
photo: string;
};
export type MenuItemData = {
menuname: string;
parsed_url: string | null;
order: number;
is_member_only: boolean;
children: Array<App.Data.MenuItemData>;
};
}
declare namespace App.Enums {
export enum IsAlfredThereEnum { THERE = 'there', AWAY = 'away', UNKNOWN = 'unknown', JUR = 'jur', TEXT_ONLY = 'text' };
export enum MembershipTypeEnum { PENDING = 0, REGULAR = 1, PET = 2, LIFELONG = 3, HONORARY = 4, DONOR = 5 };
}
