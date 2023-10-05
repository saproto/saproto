<?php

namespace Database\Factories;

use App\Models\CodexSong;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CodexSongFactory extends Factory
{
    protected $model = CodexSong::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'artist' => $this->faker->word(),
            'lyrics' => $this->faker->word(),
            'youtube' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
