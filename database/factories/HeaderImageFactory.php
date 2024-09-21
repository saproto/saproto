<?php

namespace Database\Factories;

use App\Models\HeaderImage;
use App\Models\StorageEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HeaderImageFactory extends Factory
{
    protected $model = HeaderImage::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'credit_id' => User::factory(),
            'image_id' => StorageEntry::factory(),
        ];
    }
}
