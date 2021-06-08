<?php

namespace Database\Factories;

use Proto\Models\OrderLine;
use Proto\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    public function definition()
    {
        $min_time = date('U', strtotime('-1 year'));
        $max_time = date('U', strtotime('now'));

        $product = Product::inRandomOrder()->first();

        $date = date('Y-m-d H:i:s', mt_rand($min_time, $max_time));
        $nbUnits = mt_rand(1, 3);
        $paidCash = mt_rand(1, 100);

        return [
            'product_id' => $product->id,
            'original_unit_price' => $product->price,
            'units' => $nbUnits,
            'total_price' => $nbUnits * $product->price,
            'created_at' => $date,
            'cashier_id' => null,
            'payed_with_bank_card' => $paidCash == 1 ? $date: null,
            'description' => $this->faker->sentences(3, true),
        ];
    }
}