<?php

use Faker\Generator as Faker;

/** @var $factory Closure */
$factory->define(Proto\Models\Bank::class, function (Faker $faker) {
    return [
        'iban' => $faker->iban(null),
        'bic' => $faker->swiftBicNumber,
        'machtigingid' => 'PROTOX' . mt_rand(10000, 99999) . 'X' . mt_rand(10000, 99999)
    ];
});
