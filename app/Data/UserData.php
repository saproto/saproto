<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $calling_name,
        public string  $email,
        public bool    $is_member,
        public string  $photo_preview,
        public bool    $is_protube_admin,
        public string  $theme,
        public ?string $welcome_message = null,
    )
    {
    }
}
