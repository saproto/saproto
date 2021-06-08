<?php

namespace Database\Factories;

use Proto\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    protected $model = Bank::class;

    public function definition()
    {
        return [
            'iban' => $this->faker->iban(null),
            'bic' => $this->faker->swiftBicNumber,
            'machtigingid' => 'PROTOX' . mt_rand(10000, 99999) . 'X' . mt_rand(10000, 99999)
        ];
    }
}