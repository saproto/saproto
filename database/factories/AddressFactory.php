<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'street' => fake()->streetName,
            'number' => fake()->buildingNumber,
            'zipcode' => fake()->postcode,
            'city' => fake()->city,
            'country' => fake()->country,
        ];
    }
}
