<?php

namespace Database\Factories;

use App\Models\CodexText;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CodexTextFactory extends Factory
{
    protected $model = CodexText::class;

    public function definition(): array
    {
        return [
            'type_id' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'text' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
