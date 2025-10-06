<?php

namespace App\Console\Commands;

use App\Models\Newsitem;
use Exception;
use Illuminate\Console\Command;

class CopyNewsitemImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-newsitem-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the newsitem images from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Newsitem::query()->whereHas('featuredImage')
            ->with('featuredImage')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($newsitems) use ($bar) {
            /** @var Newsitem $item */
            foreach ($newsitems as $item) {
                try {
                    $item->addMedia($item->featuredImage->generateLocalPath())
                        ->usingName($item->featuredImage->original_filename)
                        ->usingFileName('news_'.$item->id)
                        ->preservingOriginal()
                        ->toMediaCollection();

                    $item->update(['featured_image_id' => null]);
                } catch (Exception $e) {
                    $this->warn('Newsitem: '.$item->id.' error: '.$e->getMessage());
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
