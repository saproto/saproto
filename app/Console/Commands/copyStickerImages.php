<?php

namespace App\Console\Commands;

use App\Models\Sticker;
use Exception;
use Illuminate\Console\Command;

class copyStickerImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-sticker-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the sticker images from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Sticker::query()->whereHas('image')
            ->with('image')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($stickers) use ($bar) {
            /** @var Sticker $item */
            foreach ($stickers as $item) {
                try {
                    $item->addMedia($item->image->generateLocalPath())
                        ->usingName($item->image->original_filename)
                        ->usingFileName('sticker_'.$item->id)
                        ->preservingOriginal()
                        ->toMediaCollection();

                    $item->update(['image_id' => null]);
                } catch (Exception $e) {
                    $this->warn('Sticker: '.$item->id.' error: '.$e->getMessage());
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
