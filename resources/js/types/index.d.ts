export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: App.Data.UserData;
    permissions: Record<string, boolean>;
  };
  csrf: string;
  flash: { string: string } | null;
  menuItems: Array<App.Data.MenuData>;
  impersonating: App.Data.UserData | null;
};
