<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class PhotoData extends Data
{
    public function __construct(
        public int $id,
        public bool $private,
        public int $date_taken,
        public string $url,
        public ?int $likes_count,
        public ?bool $liked_by_me,
    ) {}
}
