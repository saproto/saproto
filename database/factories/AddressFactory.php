<?php

use Faker\Generator as Faker;

/* @var $factory Closure */
$factory->define(Proto\Models\Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'zipcode' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,
    ];
});
