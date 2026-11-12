<?php

namespace Database\Factories;

use App\Models\StickerType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<StickerType>
 */
class StickerTypeFactory extends Factory
{
    #[Override]
    protected $model = StickerType::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
