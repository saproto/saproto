<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Page;

/**
 * @extends Factory<Page>
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
            'title' => fake()->unique()->words(fake()->numberBetween(1, 3)),
            'slug' => fn ($attributes) => str_slug($attributes['title']),
            'content' => fake()->paragraphs(10, true),
            'is_member_only' => fake()->boolean(),
            'featured_image_id' => null,
            'show_attachments' => false,
        ];
    }
}
