<?php

namespace App\Console\Commands;

use App\Models\Product;
use Exception;
use Illuminate\Console\Command;

class CopyProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-product-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the product images from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $productQuery = Product::query()->whereHas('image')->with('image')->orderBy('products.id');
        $bar = $this->output->createProgressBar($productQuery->count());
        $bar->start();

        $productQuery
            ->chunkById(10, function ($products) use ($bar) {
                foreach ($products as $product) {
                    try {
                        $product->addMedia($product->image->generateLocalPath())
                            ->usingName($product->image->original_filename)
                            ->usingFileName('product_'.$product->id)
                            ->preservingOriginal()
                            ->toMediaCollection();
                    } catch (Exception $e) {
                        $this->warn('Product: '.$product->id.' error: '.$e->getMessage());
                    }

                    $bar->advance();
                }
            });

        $bar->finish();
    }
}
