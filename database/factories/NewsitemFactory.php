<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Model>
 */
class NewsitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $published_at = fake()->dateTimeBetween('-1 year', '+1 year');

        return [
            'user_id' => 1,
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'is_weekly' => fake()->boolean(),
            'published_at' => $published_at,
        ];
    }
}
