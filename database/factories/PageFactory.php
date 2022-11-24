<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Proto\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->words(mt_rand(1, 3), true),
            'slug' => fake()->unique()->word(),
            'content' => fake()->paragraphs(10, true),
            'is_member_only' => mt_rand(0, 1),
            'featured_image_id' => null,
            'show_attachments' => false,
        ];
    }
}
