<?php

namespace App\Console\Commands;

use App\Models\SoundboardSound;
use Exception;
use Illuminate\Console\Command;

class MoveSoundboardSounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move-soundboard-sounds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the soundboard sounds from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = SoundboardSound::query()->whereHas('file')
            ->with('file')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($sounds) use ($bar) {
            /** @var SoundboardSound $sound */
            foreach ($sounds as $sound) {
                try {
                    $sound->addMedia($sound->file->generateLocalPath())
                        ->usingName($sound->file->original_filename)
                        ->usingFileName('soundboard_'.$sound->id)
                        ->preservingOriginal()
                        ->toMediaCollection('sound');

                    $sound->update(['file_id' => null]);
                } catch (Exception $e) {
                    $this->warn('sound: '.$sound->id.' error: '.$e->getMessage());
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
