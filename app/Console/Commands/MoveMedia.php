<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class MoveMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move-media';

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
        User::query()->whereHas('media')->with('media')->chunk(100, function ($users) {
            foreach ($users as $user) {
                try {
                    $this->info('Processing member '.$user->id);
                    $media = $user->getFirstMediaPath('profile_picture');
                    $user->addMedia($media)->toMediaCollection('profile_picture');
                } catch (Exception $exception) {
                    $this->error('Error processing member '.$user->id.': '.$exception->getMessage());
                }
            }
        });
    }
}
