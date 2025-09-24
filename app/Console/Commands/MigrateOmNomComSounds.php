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
    public function handle()
    {
        $membersToMigrate = Member::whereNotNull('omnomcom_sound_id')->get();
        $this->info('Found ' . count($membersToMigrate) . ' members to migrate.');
        foreach ($membersToMigrate as $member) {
            $this->info('Migrating member ID ' . $member->id);
            $file = Storage::disk('local')->get($member->customOmnomcomSound->filename);
            try {
                $member->addMediaFromString($file)->toMediaCollection('omnomcom_sound');
                $member->customOmnomcomSound->delete();
                $member->omnomcom_sound_id = null;
                $member->save();
                $this->info('Member ID ' . $member->id . ' migrated.');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
