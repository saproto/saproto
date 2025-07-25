<?php

namespace Database\Factories;

use App\Models\WikiPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<WikiPage>
 */
class WikiPageFactory extends Factory
{
    protected $model = WikiPage::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'slug' => fake()->slug(),
            'full_path' => fake()->word(),
            'parent_id' => fake()->randomNumber(),
            'content' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
