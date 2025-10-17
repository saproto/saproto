<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    #[Override]
    public function definition(): array
    {
        return [
            'price' => fake()->randomFloat(),
            'no_show_fee' => fake()->randomFloat(),
            'participants' => fake()->randomNumber(),
            'attendees' => null,
            'registration_start' => Date::now(),
            'registration_end' => Date::now()->addDay(),
            'deregistration_end' => Date::now()->addHour(),
            'comment' => fake()->word(),
            'redirect_url' => null,
            'closed' => false,
            'hide_participants' => false,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),

            'event_id' => Event::factory(),
        ];
    }
}
