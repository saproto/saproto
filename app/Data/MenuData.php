<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;


#[TypeScript]
class MenuData extends Data
{
    public function __construct(
        public ?int            $id,
        public ?string         $menuname,
        public ?string         $parsed_url,
        public ?bool           $is_member_only,
        /** @var Collection<MenuData> */
        public null|Collection $children
    )
    {
    }
}
