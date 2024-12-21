<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ActivityData extends Data
{
    public function __construct(
        public int $id,
        public float $price,
        public int $participants,
        public int $hide_participants,
        public int $registration_start,
        public int $registration_end,
        public int $deregistration_end,
        public ?string $redirect_url,
        /** @var Collection<UserData> */
        public ?Collection $users
    ) {}
}
