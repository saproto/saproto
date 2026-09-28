<?php

namespace App\Console\Commands;

use App\Models\Member;
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
        $query = Member::query()->whereHas('media', function ($query) {
            $query->where('collection_name', 'membership_form');
        });

        $query->chunkById(10, function ($members) {
            foreach ($members as $member) {
                $stackPath = 'membership_forms/membership_form_user_'.$member->user->id.'.pdf';
                if (Storage::disk('stack_backup')->missing($stackPath)) {
                    $media = $member->getFirstMedia('membership_form');
                    $file = $media->getPathRelativeToRoot();
                    $content = Storage::disk($media->disk)->get($file);
                    Storage::disk('stack_backup')->put($stackPath, $content);
                }
            }
        });
    }
}
