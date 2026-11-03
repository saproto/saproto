<?php

namespace Database\Factories;

use App\Models\Committee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Committee>
 */
class CommitteeFactory extends Factory
{
    protected $model = Committee::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'public' => true,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'allow_anonymous_email' => fake()->unique()->safeEmail(),
            'is_society' => fake()->boolean(),
            'is_active' => fake()->boolean(),
        ];
    }
}
