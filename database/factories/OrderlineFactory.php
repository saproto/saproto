<?php

use Faker\Generator as Faker;

/** @var $factory Closure */
$factory->define(Proto\Models\OrderLine::class,
    function (Faker $faker) {
        $mintime = date('U', strtotime('-1 year'));
        $maxtime = date('U', strtotime('now'));

        $product = Proto\Models\Product::inRandomOrder()->first();
        $userId = Proto\Models\User::inRandomOrder()->pluck('id')->first();

        $date = date('Y-m-d H:i:s', mt_rand($mintime, $maxtime));
        $nbUnits = mt_rand(1, 3);
        $paidCash = mt_rand(1, 100);

        return [
            'user_id' => $userId,
            'product_id' => $product->id,
            'original_unit_price' => $product->price,
            'units' => $nbUnits,
            'total_price' => $nbUnits * $product->price,
            'created_at' => $date,
            'cashier_id' => $paidCash == 1 ? $userId : null,
            'payed_with_bank_card' => $paidCash == 1 ? $date: null,
            'description' => $faker->sentences(3, true),
        ];
});
