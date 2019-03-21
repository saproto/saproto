<?php

use Proto\Models\User;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\Member;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    $gender = mt_rand(1, 2);
    return [
        'name' => $faker->name(($gender == 1 ? 'male' : 'female')),
        'calling_name' => $faker->firstName(($gender == 1 ? 'male' : 'female')),
        'email' => $faker->email,
        'password' => bcrypt(str_random(16)),
        'remember_token' => str_random(10),
        'birthdate' => $faker->date('Y-m-d', '-16 years'),
        'phone' => $faker->e164PhoneNumber,
        'diet' => $faker->sentence,
        'website' => $faker->url,
        'phone_visible' => mt_rand(0, 1),
        'address_visible' => mt_rand(0, 1),
        'receive_sms' => mt_rand(0, 1)
    ];
});

$factory->define(Address::class, function (Faker\Generator $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'zipcode' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country
    ];
});

$factory->define(Bank::class, function (Faker\Generator $faker) {
    return [
        'iban' => $faker->iban(null),
        'bic' => $faker->swiftBicNumber,
        'machtigingid' => 'PROTOX' . mt_rand(10000, 99999) . 'X' . mt_rand(10000, 99999)
    ];
});

$factory->define(Member::class, function (Faker\Generator $faker) {
    $picktime = $faker->dateTimeInInterval('April 20, 2011', 'now');
    return [
        'proto_username' => strtolower(str_random(16)),
        'created_at' => $faker->dateTime($picktime)->format('Y-m-d H:i:s'),
        'deleted_at' => (mt_rand(0, 1) === 1 ? null : $faker->dateTimeBetween($picktime, '+1 year')->format('Y-m-d H:i:s')),
        'is_lifelong' => mt_rand(0, 1),
        'is_honorary' => mt_rand(0, 1),
        'is_donator' => mt_rand(0, 1)
    ];
});