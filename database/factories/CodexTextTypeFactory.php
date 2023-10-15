<?php

namespace Database\Factories;

use App\Models\CodexTextType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CodexTextTypeFactory extends Factory
{
    protected $model = CodexTextType::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
