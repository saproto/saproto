<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Achievement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Proto\Models\AchievementOwnership>
 */
class AchievementOwnershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $minTime = date('U', strtotime('-1 year'));
        $maxTime = date('U', strtotime('now'));

        /** @var Achievement $achievement */
        $achievement = Achievement::inRandomOrder()->first();

        $date = date('Y-m-d H:i:s', mt_rand($minTime, $maxTime));
        $alerted = mt_rand(0,1);

        return [
            'achievement_id' => $achievement->id,
            'created_at' => $date,
            'updated_at' => $date,
            'alerted' => $alerted,
        ];
    }
}
