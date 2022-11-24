<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\CommitteeMembership;

/**
 * @extends Factory<CommitteeMembership>
 */
class CommitteeMembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $minTime = date('U', strtotime('-1 year'));
        $maxTime = date('U', strtotime('+1 year'));

        $date = [date('Y-m-d H:i:s', mt_rand($minTime, $maxTime)), date('Y-m-d H:i:s', mt_rand($minTime, $maxTime))];
        if ($date[0] < $date[1]) {
            $startDate = $date[0];
            $endDate = $date[1];
        } else {
            $startDate = $date[1];
            $endDate = $date[0];
        }

        return [
            'role' => 'Automatically Added',
            'edition' => (mt_rand(1, 2) == 1 ? mt_rand(1, 5) : null),
            'created_at' => $startDate,
            'deleted_at' => (mt_rand(1, 3) == 1 ? $endDate : null),
        ];
    }
}
