<?php

namespace Database\Factories;

use App\Models\CodexSong;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<CodexSong>
 */
class CodexSongFactory extends Factory
{
    protected $model = CodexSong::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'artist' => fake()->word(),
            'lyrics' => fake()->word(),
            'youtube' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
