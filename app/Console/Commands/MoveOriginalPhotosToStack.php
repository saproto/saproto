<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MoveOriginalPhotosToStack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move-original-photos-to-stack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photos = Photo::query()->withoutGlobalScopes()->whereHas('media', function ($q){
            $q->where('media.updated_at', '<', Carbon::now()->subDay());
        })->orderBy('id');

        $bar = $this->output->createProgressBar($photos->count());
        $bar->start();

        $photos
            ->chunkById(100, function ($photos) use ($bar) {
                foreach ($photos as $photo) {
                    try {
                        $media = $photo->getFirstMedia('*');
                        $media->move($photo, $photo->private ? 'public' : 'private');
                    }catch (Exception $exception){
                        $this->warn("Photo: ".$photo->id. " :".$exception->getMessage());
                    }

                    $bar->advance();
                }
            });
    }
}
