<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/** @typescript */
class PhotoAlbumData extends Data
{
    public function __construct(
        public int|string $id,
        public string $name,
        public bool $private,

        /** @var Collection<int, PhotoData> */
        #[DataCollectionOf(PhotoData::class)]
        public ?Collection $items,
    ) {}
}
