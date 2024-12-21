<?php

namespace App\Data;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class EventData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $image_url,
        public string $location,
        public bool $is_featured,
        public bool $is_external,
        public bool $involves_food,
        public int $unique_users_count,
        public bool $secret,
        public DateTime $start,
        public DateTime $end,
        public ?string $maps_location,
        public ?DateTime $publication,
        public ?ActivityData $activity,
        public ?int $committee_id,
        public ?CommitteeData $committee,
        /** @var Collection<UserData> */
        public ?Collection $users
    ) {}
}
