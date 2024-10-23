<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(),
            'no_show_fee' => $this->faker->randomFloat(),
            'participants' => $this->faker->randomNumber(),
            'attendees' => null,
            'registration_start' => Carbon::now(),
            'registration_end' => Carbon::now()->addDay(),
            'deregistration_end' => Carbon::now()->addHour(),
            'comment' => $this->faker->word(),
            'redirect_url' => null,
            'closed' => false,
            'hide_participants' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'event_id' => Event::factory(),
        ];
    }
}
