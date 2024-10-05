<?php

namespace Database\Factories;

use App\Models\CodexText;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<CodexText>
 */
class CodexTextFactory extends Factory
{
    protected $model = CodexText::class;

    public function definition(): array
    {
        return [
            'type_id' => fake()->randomNumber(),
            'name' => fake()->name(),
            'text' => fake()->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
