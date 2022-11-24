<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Member;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $picktime = fake()->dateTimeBetween('2011-04-20');
        return [
            'created_at' => fake()->dateTime($picktime)->format('Y-m-d H:i:s'),
            'deleted_at' => (mt_rand(0, 1) === 1 ? null : fake()->dateTimeBetween($picktime)->format('Y-m-d H:i:s')),
            'is_lifelong' => mt_rand(0, 100) > 94 ? 1 : 0,
            'is_honorary' => mt_rand(0, 100) > 98 ? 1 : 0,
            'is_donor' => mt_rand(0, 100) > 98 ? 1 : 0,
            'is_pet' => mt_rand(0, 100) > 98 ? 1 : 0,
            'is_pending' => mt_rand(0, 100) > 85 ? 1 : 0,
        ];
    }
}
