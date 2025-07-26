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
        public string $small_url,
        public string $medium_url,
        public string $large_url,
        public ?int $likes_count,
        public ?bool $liked_by_me,
    ) {}

    public static function fromModel(?Photo $photo): ?self
    {
        return $photo instanceof Photo ? new self(
            $photo->id,
            $photo->private,
            $photo->date_taken,
            $photo->getUrl(),
            $photo->getUrl(PhotoEnum::SMALL),
            $photo->getUrl(PhotoEnum::MEDIUM),
            $photo->getUrl(PhotoEnum::LARGE),
            $photo->likes_count,
            $photo->liked_by_me,
        ) : null;
    }
}
