<?php

namespace Database\Factories;

use App\Models\Codex;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CodexFactory extends Factory
{
    protected $model = Codex::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'export' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
