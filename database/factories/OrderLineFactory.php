<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Proto\Models\Committee;
use Proto\Models\OrderLine;
use Proto\Models\Product;

/**
 * @extends Factory<OrderLine>
 */
class OrderLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $minTime = date('U', strtotime('-1 year'));
        $maxTime = date('U', strtotime('now'));

        /** @var Product $product */
        $product = Product::inRandomOrder()->first();

        $date = date('Y-m-d H:i:s', mt_rand($minTime, $maxTime));
        $nbUnits = mt_rand(1, 3);
        $paidCash = mt_rand(1, 100);
        $tipcie = Committee::find(config('proto.committee.tipcie'));

        return [
            'product_id' => $product->id,
            'original_unit_price' => $product->price,
            'units' => $nbUnits,
            'total_price' => $nbUnits * $product->price,
            'created_at' => $date,
            'cashier_id' => $paidCash == 1 ? $tipcie->users()->inRandomOrder()->first()->id : null,
            'payed_with_bank_card' => $paidCash == 1 ? $date : null,
            'description' => fake()->sentences(3, true),
        ];
    }
}
