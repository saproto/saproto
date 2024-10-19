<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MemberData extends Data
{
    public function __construct(
        public int       $id,
        public ?UserData $user,
        public int       $membership_form_id,
        public string    $created_at,
        public string    $deleted_at,
        public string    $updated_at,
        public bool      $is_honorary,
        public bool      $is_donor,
        public bool      $is_lifelong,
        public bool      $is_pet,
    )
    {
    }
}
