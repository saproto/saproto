<?php

namespace Database\Factories;

use Proto\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        $pick_time = $this->faker->dateTimeInInterval('April 20, 2011', 'now');
        return [
            'proto_username' => strtolower(str_random(16)),
            'created_at' => $this->faker->dateTime($pick_time)->format('Y-m-d H:i:s'),
            'deleted_at' => (mt_rand(0, 1) === 1 ? null : $this->faker->dateTimeBetween($pick_time, '+1 year')->format('Y-m-d H:i:s')),
            'is_lifelong' => mt_rand(0, 100) > 94 ? 1 : 0,
            'is_honorary' => mt_rand(0, 100) > 98 ? 1 : 0,
            'is_donator' => mt_rand(0, 100) > 98 ? 1 : 0,
            'pending' => mt_rand(0, 100) > 85 ? 1 : 0,
        ];
    }
}