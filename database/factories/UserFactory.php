<?php

namespace Database\Factories;

use Proto\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $gender = mt_rand(1, 2);

        return [
            'name' => $this->faker->name(($gender == 1 ? 'male' : 'female')),
            'calling_name' => $this->faker->firstName(($gender == 1 ? 'male' : 'female')),
            'email' => $this->faker->unique()->email,
            'password' => bcrypt(str_random(16)),
            'remember_token' => str_random(10),
            'birthdate' => $this->faker->date('Y-m-d', '-16 years'),
            'phone' => $this->faker->e164PhoneNumber,
            'diet' => $this->faker->sentence,
            'website' => $this->faker->url,
            'phone_visible' => mt_rand(0, 1),
            'address_visible' => mt_rand(0, 1),
            'receive_sms' => mt_rand(0, 1),
            'keep_protube_history' => mt_rand(0, 1),
            'show_birthday' => mt_rand(0, 1),
            'show_achievements' => mt_rand(0, 1),
            'show_omnomcom_total' => mt_rand(0, 1),
            'show_omnomcom_calories' => mt_rand(0, 1),
            'disable_omnomcom' => mt_rand(0, 1),
            'theme' => config('proto.themes')[mt_rand(0, count(config('proto.themes'))-1)],
            'did_study_create' => mt_rand(0, 20) < 15 ? 1 : 0,
            'did_study_itech' => mt_rand(0, 20) < 5 ? 1 : 0,
        ];
    }
}
