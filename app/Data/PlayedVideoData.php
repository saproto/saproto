<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class PlayedVideoData extends Data
{
    public function __construct(
        public string $video_id,
        public string $video_title,
        public ?float $sum_duration,
        public ?float $sum_duration_played,
        public int $played_count,
    ) {}
}
