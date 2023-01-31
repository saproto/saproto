<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\WallstreetDrink;
use Proto\Models\WallstreetPrice;

class UpdateWallstreetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:updatewallstreetprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the prices when a wallstreet drink is active';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get the wallstreet drink that is currently active
        $currentDrink = WallstreetDrink::where('start_time', '<=', time())->where('end_time', '>=', time())->first();
        //get all products that does_wallstreet is true
        $products = Product::where('does_wallstreet', true)->get();
        //loop through all products and decrease the current_wallstreet_price by 0.02
        foreach ($products as $product) {
            $latestPrice = WallstreetPrice::query()->where('product_id', $product->id)->orderBy('created_at', 'desc')->first();

            $newOrderlines=OrderLine::query()->where('created_at', '>=', \Carbon::now()->subMinute())->where('product_id', $product->id)->sum('units');

                if($newOrderlines>0){
                    $delta= $newOrderlines*0.05;
                        $newPriceObject = new WallstreetPrice([
                            'drink_id' => $product->id,
                            'product_id' => $product->id,
                            'price' => $latestPrice->price+$delta>$product->price?$product->price:$latestPrice->price+$delta,
                        ]);
                        $newPriceObject->save();
                        continue;
                }

                if($latestPrice->price!==0.10) {
                    $newPriceObject = new WallstreetPrice([
                        'drink_id' => $currentDrink->id,
                        'product_id' => $product->id,
                        'price' => $latestPrice->price - 0.02 < 0.10 ? 0.10 : $latestPrice->price - 0.02,
                    ]);
                    $newPriceObject->save();
                }
        }

    }
}
