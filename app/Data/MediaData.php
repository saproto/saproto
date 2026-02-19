<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/** @typescript */
class MediaData extends Data
{
    public function __construct(
        public int $id,
        public string $url,
        public string $srcset,
    ) {}

    public static function fromModel(Media $media): self
    {
        return new self(
            id: $media->id,
            url: $media->getFullUrl(),
            srcset: $media->getSrcset(),
        );
    }
}

