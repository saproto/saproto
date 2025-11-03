<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class OrderlineData extends Data
{
    public function __construct(
        public int $id,
        public int $product_id,
        public int $units,
        public float $total_price,
        public string $created_at,
        public ProductData $product,
    ) {}
}
