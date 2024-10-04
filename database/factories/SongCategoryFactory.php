<?php

namespace Database\Factories;

use App\Models\SongCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<SongCategory>
 */
class SongCategoryFactory extends Factory
{
    protected $model = SongCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
