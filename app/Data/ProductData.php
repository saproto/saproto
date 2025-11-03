<?php

namespace App\Data;

use App\Enums\ProductEnum;
use App\Models\Product;
use Spatie\LaravelData\Data;

/** @typescript */
class ProductData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public float $calories,
        public bool $is_alcoholic,
        public string $image_url
    ) {}

    public static function fromModel(?Product $product): ?self
    {
        return $product instanceof Product ? new self(
            $product->id,
            $product->name,
            $product->price,
            $product->calories,
            $product->is_alcoholic,
            $product->getImageUrl(ProductEnum::THUMB)
        ) : null;
    }
}
