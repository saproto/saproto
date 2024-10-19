declare namespace App.Data {
  export type ActivityData = {
    id: number;
    price: number;
    participants: number;
    hide_participants: number;
    registration_start: number;
    registration_end: number;
    deregistration_end: number;
    redirect_url: string | null;
    users: Array<App.Data.UserData> | null;
  };
  export type AddressData = {
    id: number;
    street: string;
    number: string;
    user: App.Data.UserData | null;
  };
  export type BankData = {
    id: number;
    user: App.Data.UserData | null;
  };
  export type CommitteeData = {
    id: number;
    name: string;
    slug: string;
    description: string;
  };
  export type EventData = {
    id: number;
    title: string;
    description: string;
    image_url: string;
    location: string;
    is_featured: boolean;
    is_external: boolean;
    involves_food: boolean;
    unique_users_count: number;
    secret: boolean;
    start: string;
    end: string;
    maps_location: string | null;
    publication: string | null;
    activity: App.Data.ActivityData | null;
    committee_id: number | null;
    committee: App.Data.CommitteeData | null;
    users: Array<App.Data.UserData> | null;
  };
  export type MemberData = {
    id: number;
    user: App.Data.UserData | null;
    created_at: string;
    updated_at: string;
    is_honorary: boolean;
    is_donor: boolean;
    is_lifelong: boolean;
    is_pet: boolean;
  };
  export type MenuData = {
    id: number | null;
    menuname: string | null;
    parsed_url: string | null;
    is_member_only: boolean | null;
    children: Array<App.Data.MenuData> | null;
  };
  export type ProductData = {
    id: number;
    name: string;
    price: number;
    stock: number;
    image_url: string;
  };
  export type TicketData = {
    id: number;
    event: App.Data.ActivityData;
    product: App.Data.ProductData;
    purchases: Array<App.Data.TicketPurchaseData>;
  };
  export type TicketPurchaseData = {
    id: number;
    payment_complete: boolean;
    scanned: string | null;
    user: App.Data.UserData | null;
    ticket: App.Data.TicketData | null;
  };
  export type UserData = {
    id: number;
    name: string;
    calling_name: string;
    email: string;
    is_member: boolean;
    member: App.Data.MemberData | null;
    photo_preview: string;
    theme: string;
    welcome_message: string | null;
    phone: boolean | null;
    birthdate: string | null;
    edu_username: string | null;
    utwente_username: string | null;
    website: string | null;
    is_protube_admin: boolean;
    address_visible: boolean;
    did_study_create: boolean;
    did_study_itech: boolean;
    profile_in_almanac: boolean;
    show_achievements: boolean;
    keep_omnomcom_history: boolean;
    disable_omnomcom: boolean;
    show_omnomcom_calories: boolean;
    show_omnomcom_total: boolean;
    show_birthday: boolean;
    phone_visible: boolean;
    receive_sms: boolean;
    address: App.Data.AddressData | null;
    bank: App.Data.BankData | null;
  };
}
