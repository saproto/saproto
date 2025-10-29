<?php

namespace Database\Factories;

use App\Models\StickerType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<StickerType>
 */
class StickerTypeFactory extends Factory
{
    protected $model = StickerType::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
