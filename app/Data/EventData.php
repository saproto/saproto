<?php

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class EventData extends Data
{
    public function __construct(
        public int            $id,
        public string         $title,
        public string         $description,
        public string         $image_url,
        public string         $location,
        public bool           $is_featured,
        public bool           $is_external,
        public bool           $involves_food,
        public int            $unique_users_count,
        public string         $maps_location,
        public bool           $secret,
        public DateTime       $start,
        public DateTime       $end,
        public ?DateTime      $publication,
        public ?ActivityData  $activity,
        public ?CommitteeData $committee,
    )
    {
    }
}
