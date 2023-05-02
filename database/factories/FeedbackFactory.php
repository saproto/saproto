<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Feedback;
use Proto\Models\User;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'feedback' => fake()->realTextBetween(50, 200),
        ];
    }
}
