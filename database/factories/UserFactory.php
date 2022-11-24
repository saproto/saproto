<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = mt_rand(1, 2);

        return [
            'name' => fake()->name($gender == 1 ? 'male' : 'female'),
            'calling_name' => fake()->firstName(($gender == 1 ? 'male' : 'female')),
            'email' => fake()->unique()->email,
            'password' => bcrypt(str_random(16)),
            'remember_token' => str_random(10),
            'birthdate' => fake()->date('Y-m-d', '-16 years'),
            'phone' => fake()->e164PhoneNumber,
            'diet' => fake()->sentence,
            'website' => fake()->url,
            'phone_visible' => mt_rand(0, 1),
            'address_visible' => mt_rand(0, 1),
            'receive_sms' => mt_rand(0, 1),
            'keep_protube_history' => mt_rand(0, 1),
            'show_birthday' => mt_rand(0, 1),
            'show_achievements' => mt_rand(0, 1),
            'show_omnomcom_total' => mt_rand(0, 1),
            'show_omnomcom_calories' => mt_rand(0, 1),
            'disable_omnomcom' => mt_rand(0, 1),
            'theme' => ['assets/application-light.css', 'assets/application-dark.css'][mt_rand(0, 1)],
            'did_study_create' => mt_rand(0, 20) < 15 ? 1 : 0,
            'did_study_itech' => mt_rand(0, 20) < 5 ? 1 : 0,
        ];
    }
}
