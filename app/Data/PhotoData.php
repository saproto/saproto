<?php

namespace App\Data;

use App\Enums\PhotoEnum;
use App\Models\Photo;
use Spatie\LaravelData\Data;

/** @typescript */
class PhotoData extends Data
{
    public function __construct(
        public int $id,
        public bool $private,
        public int $date_taken,
        public string $url,
        public string $large_url,
        public ?int $likes_count,
        public ?bool $liked_by_me,
        public ?PhotoAlbumData $album,
        public ?MediaData $media,
    ) {}

    public static function fromModel(?Photo $photo): ?self
    {
        return $photo instanceof Photo ? new self(
            $photo->id,
            $photo->private,
            $photo->date_taken,
            $photo->getUrl(),
            $photo->getUrl(PhotoEnum::LARGE),
            $photo->likes_count,
            $photo->liked_by_me,
            $photo->relationLoaded('album') ? PhotoAlbumData::from($photo->album) : null,
            MediaData::fromModel($photo->getFirstMedia('*')),
        ) : null;
    }
}
