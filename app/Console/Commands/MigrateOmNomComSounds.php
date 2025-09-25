<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MigrateOmNomComSounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:migrate-om-nom-com-sounds';

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
        $membersToMigrate = Member::query()->whereNotNull('omnomcom_sound_id')->with('customOmnomcomSound')->get();
        $this->info('Found '.count($membersToMigrate).' members to migrate.');
        foreach ($membersToMigrate as $member) {
            $this->info('Migrating member ID '.$member->id);
            $file = Storage::disk('local')->get($member->customOmnomcomSound->filename);
            if (! $file) {
                $this->error('Could not read file for member ID '.$member->id);

                continue;
            }

            try {
                $member->addMediaFromString($file)->toMediaCollection('omnomcom_sound');
                $member->customOmnomcomSound->delete();
                $member->omnomcom_sound_id = null;
                $member->save();
                $this->info('Member ID '.$member->id.' migrated.');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
