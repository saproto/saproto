<?php

namespace Database\Factories;

use App\Models\Dinnerform;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DinnerformFactory extends Factory
{
    protected $model = Dinnerform::class;

    public function definition(): array
    {
        return [
            'restaurant' => $this->faker->word(),
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'event_id' => Event::factory(),
            'helper_discount' => $this->faker->randomFloat(),
            'regular_discount' => $this->faker->randomFloat(),
            'closed' => 0,
            'visible_home_page' => $this->faker->boolean(),
            'ordered_by_user_id' => User::factory(),
        ];
    }
}
