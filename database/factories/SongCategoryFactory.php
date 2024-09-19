<?php

namespace Database\Factories;

use App\Models\CodexSongCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SongCategoryFactory extends Factory
{
    protected $model = CodexSongCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
