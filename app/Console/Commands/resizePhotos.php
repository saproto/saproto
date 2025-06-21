<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class resizePhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:resize-photos';

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
       User::query()->whereHas('photo')->whereHas('roles', function ($q){
           $q->where('name', 'sysadmin');
       })->with('photo')->chunkById(100, function ($users) {
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
