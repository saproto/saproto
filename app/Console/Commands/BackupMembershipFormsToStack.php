<?php

namespace App\Console\Commands;

use App\Models\StorageEntry;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('proto:backup_membershipforms_to_stack')]
#[Description('Backup up the membership forms to the stack drive')]
class BackupMembershipFormsToStack extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = StorageEntry::query()->whereHas('member', function ($q) {
            $q->withTrashed();
        })->with('member')->orderBy('id');

        $query->chunkById(10, function ($entries) {
            foreach ($entries as $entry) {
                $stackPath = 'membership_forms/'.$entry->original_filename;
                if (Storage::disk('stack_backup')->missing($stackPath)) {
                    $content = Storage::disk('local')->get($entry->filename);
                    Storage::disk('stack_backup')->put($stackPath, $content);
                }
            }
        });
    }
}
