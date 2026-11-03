<?php

namespace Database\Factories;

use App\Models\HeaderImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<HeaderImage>
 */
class HeaderImageFactory extends Factory
{
    protected $model = HeaderImage::class;

    #[Override]
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),

            'credit_id' => User::factory(),
        ];
    }
}
