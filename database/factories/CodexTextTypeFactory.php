<?php

namespace Database\Factories;

use App\Models\CodexTextType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<CodexTextType>
 */
class CodexTextTypeFactory extends Factory
{
    protected $model = CodexTextType::class;

    #[Override]
    public function definition(): array
    {
        return [
            'type' => fake()->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
