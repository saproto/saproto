<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateDateTakenFromExif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:update-date-taken-from-exif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loop through all the photos, and fix their date_taken if it does not match the exif';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photos = Photo::query()->withoutGlobalScopes()->whereHas('media');
        $bar = $this->output->createProgressBar($photos->count());
        $bar->start();

        $photos
            ->chunkById(100, function ($photos) use ($bar) {
                foreach ($photos as $photo) {
                    $path = $photo->getFirstMedia()->getPath();
                    $date = exif_read_data($path)['DateTimeOriginal'] ?? null;
                    if ($date) {
                        $date = Carbon::parse($date)->timestamp;
                        if ($photo->date_taken !== $date) {
                            $this->info('Updating '.$photo->id.' from '.$photo->date_taken.' to '.$date);
                            $photo->update(['date_taken' => $date]);
                        }
                    }

                    $bar->advance();
                }
            });
    }
}
