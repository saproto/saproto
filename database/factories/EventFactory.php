<?php

namespace Database\Factories;

use App\Enums\VisibilityEnum;
use App\Models\Committee;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\StorageEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Override;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    #[Override]
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'start' => fake()->dateTimeBetween('-1 week')->getTimestamp(),
            'end' => fake()->dateTimeBetween('now', '+1 week')->getTimestamp(),
            'publication' => null,
            'summary' => fake()->text(),
            'location' => fake()->word(),
            'is_featured' => fake()->boolean(),
            'is_external' => fake()->boolean(),
            'involves_food' => fake()->boolean(),
            'visibility' => VisibilityEnum::PUBLIC,
            'force_calendar_sync' => fake()->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'unique_users_count' => fake()->randomNumber(),
            'image_id' => StorageEntry::factory(),
            'committee_id' => Committee::factory(),
            'category_id' => EventCategory::factory(),
        ];
    }
}
