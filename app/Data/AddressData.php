<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AddressData extends Data
{
    public function __construct(
        public int $id,
        public string $street,
        public string $number,
        public ?UserData $user,
    ) {}
}
