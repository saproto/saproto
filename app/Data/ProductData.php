<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ProductData extends Data
{
    public function __construct(
        public int    $id,
        public string $name,
        public float  $price,
        public int    $stock,
        public string $image_url,
    )
    {
    }
}
