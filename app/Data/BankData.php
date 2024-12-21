<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BankData extends Data
{
    public function __construct(
        public int $id,
        public string $machtigingid,
        public Carbon $created_at,
        public ?UserData $user,
    ) {}
}
