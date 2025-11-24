<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/** @typescript */
class ProductCategoryData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        /** @var Collection<int, ProductData> */
        #[DataCollectionOf(ProductData::class)]
        public ?Collection $sortedProducts,
    ) {}
}
