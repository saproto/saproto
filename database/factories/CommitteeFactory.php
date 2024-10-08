<?php

namespace Database\Factories;

use App\Models\Committee;
use App\Models\StorageEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommitteeFactory extends Factory
{
    protected $model = Committee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'public' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'allow_anonymous_email' => $this->faker->unique()->safeEmail(),
            'is_society' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
            'image_id' => StorageEntry::factory(),
        ];
    }
}
