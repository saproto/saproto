<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Activity;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Proto\Models\ActivityParticipation>
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
            'created_at' => fn ($attributes) => self::startDate($attributes),
            'deleted_at' => fn ($attributes) => mt_rand(1, 3) == 1 ? self::endDate($attributes) : null,
            'backup' => fn ($attributes) => self::Backup($attributes),
        ];
    }

    public function startDate(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        $mintime = date('U', strtotime($activity->registration_start));
        $maxtime = date('U', strtotime($activity->event->start));
        return date('U', ($maxtime > $mintime ? mt_rand($mintime, $maxtime) : $mintime));
    }

    public function endDate(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        $mintime = date('U', strtotime($activity->registration_start));
        $maxtime = date('U', strtotime($activity->event->start));
        $startDate = date('U', ($maxtime > $mintime ? mt_rand($mintime, $maxtime) : $mintime));
        return date('Y-m-d H:i:s', ($maxtime > $startDate ? mt_rand($startDate, $maxtime) : $maxtime));
    }

    public function backup(array $attributes) {
        $activity = Activity::find($attributes['activity_id']);
        return $activity->freeSpots() == 0;
    }
}
