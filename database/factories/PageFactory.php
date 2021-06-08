<?php

namespace Database\Factories;

use Proto\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(mt_rand(1, 3), true),
            'slug' => $this->faker->unique()->word(),
            'content' => $this->faker->paragraphs(10, true),
            'is_member_only' => mt_rand(0, 1),
            'featured_image_id' => null,
            'show_attachments' => false
        ];
    }
}