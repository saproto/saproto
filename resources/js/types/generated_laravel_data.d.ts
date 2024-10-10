declare namespace App.Data {
  export type ActivityData = {
    id: number;
    price: number;
    participants: number;
    hide_participants: number;
    registration_start: number;
    registration_end: number;
    deregistration_end: number;
    redirect_url: string;
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
    start: string;
    end: string;
    activity: App.Data.ActivityData | null;
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
    name: string;
    calling_name: string;
    email: string;
    is_member: boolean;
    photo_preview: string;
    is_protube_admin: boolean;
    theme: string;
    welcome_message: string | null;
  };
}
