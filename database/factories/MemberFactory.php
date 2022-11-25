<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Member;
use Proto\Models\User;

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
        $created_at = fake()->dateTimeBetween('2011-04-20');
        return [
            'created_at' => fake()->dateTime($created_at)->format('Y-m-d H:i:s'),
            'deleted_at' => (mt_rand(0, 1) === 1 ? null : fake()->dateTimeBetween($created_at)->format('Y-m-d H:i:s')),
            'is_pending' => mt_rand(0, 100) > 85 ? 1 : 0,
            'user_id' => User::factory()->hasBank()->hasAddress(),
            'proto_username' => fn ($attributes) => Member::createProtoUsername(User::find($attributes['user_id'])->name)
        ];
    }
}
