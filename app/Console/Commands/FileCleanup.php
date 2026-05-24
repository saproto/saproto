<?php

namespace App\Console\Commands;

use App\Models\StorageEntry;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Description('Clears all files that are orphaned (i.e. not referenced anywhere) for privacy reasons as well as storage space.')]
#[Signature('proto:filecleanup')]
class FileCleanup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting clean-up.');

        $count = 0;

        StorageEntry::query()->chunkById(500, function ($files) use (&$count) {
            foreach ($files as $file) {
                if ($file->isOrphan()) {
                    $count++;
                    Storage::disk('local')->delete($file->filename);
                    $file->delete();
                }
            }
        });

        $this->info("Found and deleted {$count} orphaned files.");
    }
}
