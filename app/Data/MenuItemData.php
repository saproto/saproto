<?php

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\MenuItem;
use App\Models\Page;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;

/** @typescript */
class MenuItemData extends Data
{
    public function __construct(
        public int $id,

        public ?MenuItem $parent,

        public string $menuname,

        public ?string $url,

        public ?int $page_id,

        public ?Carbon $created_at,

        public ?Carbon $updated_at,

        public int $order,

        public bool $is_member_only,

        #[DataCollectionOf(MenuItemData::class)]
        public Collection $children,

        public ?int $children_count,

        public ?Page $page
    ) {}
}
