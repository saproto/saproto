<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CopyProfilePictures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-profile-pictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the profile pictures from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
       User::query()->whereHas('photo')
           ->with('photo')->chunkById(100, function ($users) {
           /** @var User $user */
           foreach ($users as $user) {
                $user->addMedia($user->photo->generateLocalPath())
                    ->usingName($user->photo->original_filename)
                    ->usingFileName($user->photo->original_filename)
                    ->preservingOriginal()
                    ->toMediaCollection('profile_picture');
                    $user->update([
                        'image_id' => null
                    ]);
            }
       });
    }
}
