declare namespace App {
namespace Data {
export type AuthUserData = {
id: number,
calling_name: string,
roles: string[],
is_member: boolean,
avatar: string,
email: string,
};
export type MenuItemData = {
menuname: string,
parsed_url: string | null,
order: number,
is_member_only: boolean,
children: App.Data.MenuItemData[],
};
export type OrderlineData = {
id: number,
product_id: number,
units: number,
total_price: number,
created_at: string,
product: App.Data.ProductData,
};
export type PhotoAlbumData = {
id: string | number,
name: string,
private: boolean,
thumbPhoto: App.Data.PhotoData | null,
items: App.Data.PhotoData[],
};
export type PhotoData = {
id: number,
private: boolean,
date_taken: number,
url: string,
large_url: string,
likes_count: number | null,
liked_by_me: boolean | null,
album: App.Data.PhotoAlbumData | null,
};
export type PlayedVideoData = {
video_id: string,
video_title: string,
sum_duration: number | null,
sum_duration_played: number | null,
played_count: number,
};
export type ProductCategoryData = {
id: number,
name: string,
sortedProducts: App.Data.ProductData[],
};
export type ProductData = {
id: number,
name: string,
price: number,
calories: number,
is_alcoholic: boolean,
stock: number,
image_url: string,
};
}
namespace Enums {
export enum CommitteeEnum {
    CARD = 'card',
    BLOCK = 'block',
    HEADER = 'header',
}
export enum CompanyEnum {
    LARGE = 'large',
    SMALL = 'small',
}
export enum HeaderImageEnum {
    LARGE = 'large',
}
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
export enum MollieEnum {
    PAID = 'paid',
    FAILED = 'failed',
    OPEN = 'open',
    UNKNOWN = 'unknown',
}
export enum NarrowcastingEnum {
    LARGE = 'large',
    SMALL = 'small',
}
export enum NewsEnum {
    CARD = 'card',
    LARGE = 'large',
}
export enum PageEnum {
    LARGE = 'large',
}
export enum PhotoEnum {
    ORIGINAL = 'original',
    LARGE = 'large',
    SMALL = 'small',
}
export enum ProductEnum {
    LARGE = 'large',
    THUMB = 'thumb',
}
export enum StickerEnum {
    LARGE = 'large',
    SMALL = 'small',
}
export enum StickerTypeEnum {
    LARGE = 'large',
    TINY = 'tiny',
}
}
}
declare namespace Illuminate {
export type CursorPaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[],
links: {
url: string | null,
label: string,
active: boolean,
}[],
meta: {
path: string,
per_page: number,
next_cursor: string | null,
next_page_url: string | null,
prev_cursor: string | null,
prev_page_url: string | null,
},
};
export type CursorPaginatorInterface<TKey, TValue> = Illuminate.CursorPaginator<TKey, TValue>;
export type LengthAwarePaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[],
links: {
url: string | null,
label: string,
active: boolean,
}[],
meta: {
total: number,
current_page: number,
first_page_url: string,
from: number | null,
last_page: number,
last_page_url: string,
next_page_url: string | null,
path: string,
per_page: number,
prev_page_url: string | null,
to: number | null,
},
};
export type LengthAwarePaginatorInterface<TKey, TValue> = Illuminate.LengthAwarePaginator<TKey, TValue>;
}
declare namespace Spatie {
namespace LaravelData {
export type CursorPaginatedDataCollection<TKey, TValue> = Illuminate.CursorPaginator<TKey, TValue>;
export type PaginatedDataCollection<TKey, TValue> = Illuminate.LengthAwarePaginator<TKey, TValue>;
}
}
