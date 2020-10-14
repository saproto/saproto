<?php

use Faker\Generator as Faker;

/** @var $factory Closure */
$factory->define(Proto\Models\Member::class,
    function (Faker $faker) {
        $picktime = $faker->dateTimeInInterval('April 20, 2011', 'now');
        return [
            'proto_username' => strtolower(str_random(16)),
            'created_at' => $faker->dateTime($picktime)->format('Y-m-d H:i:s'),
            'deleted_at' => (mt_rand(0, 1) === 1 ? null : $faker->dateTimeBetween($picktime, '+1 year')->format('Y-m-d H:i:s')),
            'is_lifelong' => mt_rand(0, 100) > 94 ? 1 : 0,
            'is_honorary' => mt_rand(0, 100) > 98 ? 1 : 0,
            'is_donator' => mt_rand(0, 100) > 98 ? 1 : 0,
            'pending' => mt_rand(0, 100) > 85 ? 1 : 0,
        ];
    });
