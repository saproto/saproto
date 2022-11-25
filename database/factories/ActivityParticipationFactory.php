<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;

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
    public function definition()
    {
        return [
            'created_at' => fn ($attributes) => self::createAt($attributes),
            'deleted_at' => fn ($attributes) => fake()->boolean(30) ? self::deletedAt($attributes) : null,
            'backup' => fn ($attributes) => self::Backup($attributes),
        ];
    }

    public function createAt(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        return fake()->dateTimeBetween($activity->registration_start, $activity->event->start)->format('Y-m-d H:i:s');
    }

    public function deletedAt(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        return fake()->dateTimeBetween($attributes['created_at'], $activity->event->start)->format('Y-m-d H:i:s');
    }

    public function backup(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        return $activity->freeSpots() == 0;
    }
}
