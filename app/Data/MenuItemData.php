<?php

namespace App\Data;

use App\Models\MenuItem;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/** @typescript */
class MenuItemData extends Data
{
    public function __construct(
        public string $menuname,

        public ?string $parsed_url,

        public int $order,

        public bool $is_member_only,

        /** @var Collection<int, MenuItemData> */
        #[DataCollectionOf(MenuItemData::class)]
        public Collection $children,
    ) {}

    public static function fromModel(?MenuItem $menuItem): ?self
    {
        return $menuItem ? new self(
            $menuItem->menuname,
            $menuItem->url,
            $menuItem->order,
            $menuItem->is_member_only,
            $menuItem->children->map(fn (MenuItem $child) => MenuItemData::fromModel($child)),
        ) : null;
    }
}
