<?php

namespace Database\Factories;

use App\Models\FeedbackCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeedbackCategory>
 */
class FeedbackCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'url' => fake()->slug(),
            'review' => fake()->boolean(),
            'reviewer_id' => null,
            'show_publisher' => fake()->boolean(),
            'can_reply' => fake()->boolean(),
        ];
    }
}
