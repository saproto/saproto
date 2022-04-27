<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var $factory Factory */
$factory->define(Proto\Models\Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'zipcode' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,
    ];
});
