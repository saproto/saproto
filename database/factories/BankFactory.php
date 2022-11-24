<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Bank;

/**
 * @extends Factory<Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'iban' => fake()->iban(),
            'bic' => fake()->swiftBicNumber,
            'machtigingid' => 'PROTOX'.mt_rand(10000, 99999).'X'.mt_rand(10000, 99999),
        ];
    }
}
