<?php

namespace Database\Factories;

use App\Models\Codex;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Codex>
 */
class CodexFactory extends Factory
{
    protected $model = Codex::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'export' => fake()->word(),
            'description' => fake()->text(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
