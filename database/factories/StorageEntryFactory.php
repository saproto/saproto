<?php

namespace Database\Factories;

use App\Models\StorageEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StorageEntryFactory extends Factory
{
    protected $model = StorageEntry::class;

    public function definition(): array
    {
        return [
            'filename' => $this->faker->word(),
            'mime' => $this->faker->word(),
            'original_filename' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'hash' => $this->faker->word(),
        ];
    }
}
