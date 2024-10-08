<?php

namespace Database\Factories;

use App\Models\Committee;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\StorageEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'start' => fake()->dateTimeBetween('-1 week', 'now')->getTimestamp(),
            'end' => fake()->dateTimeBetween('now', '+1 week')->getTimestamp(),
            'publication' => null,
            'summary' => $this->faker->text(),
            'location' => $this->faker->word(),
            'is_featured' => $this->faker->boolean(),
            'is_external' => $this->faker->boolean(),
            'involves_food' => $this->faker->boolean(),
            'secret' => $this->faker->boolean(),
            'force_calendar_sync' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'unique_users_count' => $this->faker->randomNumber(),
            'image_id' => StorageEntry::factory(),
            'committee_id' => Committee::factory(),
            'category_id' => EventCategory::factory(),
        ];
    }
}
