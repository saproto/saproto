<?php

namespace Database\Factories;

use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'subject' => $this->faker->word(),
            'sender_name' => $this->faker->name(),
            'sender_address' => $this->faker->word(),
            'body' => $this->faker->word(),
            'sent_to' => 0,
            'to_user' => false,
            'to_member' => false,
            'to_list' => false,
            'to_event' => false,
            'to_active' => false,
            'to_pending' => false,
            'to_backup' => false,
            'ready' => true,
            'sent' => false,
            'time' => Carbon::now()->timestamp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
