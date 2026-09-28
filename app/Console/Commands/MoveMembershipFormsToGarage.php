<?php

namespace App\Console\Commands;

use App\Models\StorageEntry;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:move-membership-forms-to-garage')]
#[Description('Command description')]
class MoveMembershipFormsToGarage extends Command
{
    public function handle(): void
    {
        $query = StorageEntry::query()->whereHas('member', function ($q) {
            $q->withTrashed();
        })->with('member')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());

        $query->chunkById(10, function ($entries) use ($bar) {
            foreach ($entries as $entry) {
                $content = Storage::disk('local')->get($entry->filename);
                try {
                    $entry->member->addMediaFromString($content)
                        ->usingFileName($entry->original_filename)
                        ->toMediaCollection('membership_form');

                    $entry->delete();
                    $bar->advance();
                } catch (Exception $e) {
                    $this->error("Failed to move membership form for member ID {$entry->member->id}: ".$e->getMessage());
                }
            }
        });
        $bar->finish();
    }
}
