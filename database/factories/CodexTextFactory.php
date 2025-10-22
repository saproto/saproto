<?php

namespace Database\Factories;

use App\Models\CodexText;
use App\Models\CodexTextType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<CodexText>
 */
class CodexTextFactory extends Factory
{
    protected $model = CodexText::class;

    #[Override]
    public function definition(): array
    {
        return [
            'type_id' => CodexTextType::factory(),
            'name' => fake()->name(),
            'text' => fake()->text(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
