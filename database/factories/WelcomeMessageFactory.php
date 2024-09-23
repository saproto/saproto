<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WelcomeMessage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WelcomeMessageFactory extends Factory
{
    protected $model = WelcomeMessage::class;

    public function definition(): array
    {
        return [
            'message' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
        ];
    }
}
