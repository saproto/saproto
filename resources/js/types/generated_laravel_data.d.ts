declare namespace App.Data {
  export type MenuData = {
    id: number | null;
    menuname: string | null;
    parsed_url: string | null;
    is_member_only: boolean | null;
    children: Array<App.Data.MenuData> | null;
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
