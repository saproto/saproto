<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Quote;
use Proto\Models\User;

/**
 * @extends Factory<Quote>
 */
class QuoteFactory extends Factory
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
            'quote' => fake()->realTextBetween(50, 200),
        ];
    }
}
