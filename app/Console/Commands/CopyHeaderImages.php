<?php

namespace App\Console\Commands;

use App\Models\HeaderImage;
use Exception;
use Illuminate\Console\Command;

class CopyHeaderImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-header-pictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the narrowcasting pictures from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = HeaderImage::query()->whereHas('image')
            ->with('image')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($narrowcastingItems) use ($bar) {
            /** @var HeaderImage $item */
            foreach ($narrowcastingItems as $item) {
                try {
                    $item->addMedia($item->image->generateLocalPath())
                        ->usingName($item->image->original_filename)
                        ->usingFileName('header_'.$item->id)
                        ->preservingOriginal()
                        ->toMediaCollection();

                    $item->update(['image_id' => null]);
                } catch (Exception $e) {
                    $this->warn('Header: '.$item->id.' error: '.$e->getMessage());
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
