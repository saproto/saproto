<?php

namespace Database\Factories;

use App\Models\Dinnerform;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Dinnerform>
 */
class DinnerformFactory extends Factory
{
    protected $model = Dinnerform::class;

    #[Override]
    public function definition(): array
    {
        return [
            'restaurant' => fake()->word(),
            'description' => fake()->text(),
            'url' => fake()->url(),
            'start' => Date::now(),
            'end' => Date::now(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'event_id' => Event::factory(),
            'helper_discount' => fake()->randomFloat(),
            'regular_discount' => fake()->randomFloat(),
            'closed' => 0,
            'visible_home_page' => fake()->boolean(),
            'ordered_by_user_id' => User::factory(),
        ];
    }
}
