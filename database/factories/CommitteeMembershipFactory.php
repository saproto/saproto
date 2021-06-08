<?php

namespace Database\Factories;

use Proto\Models\CommitteeMembership;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeMembershipFactory extends Factory
{
    protected $model = CommitteeMembership::class;

    public function definition()
    {
        $min_time = date('U', strtotime('-1 year'));
        $max_time = date('U', strtotime('+1 year'));

        $date = [date('Y-m-d H:i:s', mt_rand($min_time, $max_time)), date('Y-m-d H:i:s', mt_rand($min_time, $max_time))];
        if ($date[0] < $date[1]) {
            $start_date = $date[0];
            $end_date = $date[1];
        } else {
            $start_date = $date[1];
            $end_date = $date[0];
        }

        return [
            'role' => 'Automatically Added',
            'edition' => (mt_rand(1, 2) == 1 ? mt_rand(1, 5) : null),
            'created_at' => $start_date,
            'deleted_at' => (mt_rand(1, 3) == 1 ? $end_date : null)
        ];
    }
}