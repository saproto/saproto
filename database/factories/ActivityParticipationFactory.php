<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityParticipation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<ActivityParticipation>
 */
class ActivityParticipationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function definition(): array
    {
        return [
            'created_at' => fn ($attributes): string => self::createAt($attributes),
            'backup' => fn ($attributes): bool => self::Backup($attributes),
        ];
    }

    /**
     * Set created at based on activity dates.
     */
    public function createAt(array $attributes): string
    {
        $activity = Activity::query()->find($attributes['activity_id']);

        $start = Date::parse($activity->registration_start);
        $end = Date::parse($activity->event->start);

        $date = fake()->dateTimeBetween($start, $end);

        return $date->format('Y-m-d H:i:s');
    }


    /**
     * Set backup state based on available activity spots.
     */
    public function backup(array $attributes): bool
    {
        $activity = Activity::query()->find($attributes['activity_id']);

        return $activity->freeSpots() == 0;
    }
}
