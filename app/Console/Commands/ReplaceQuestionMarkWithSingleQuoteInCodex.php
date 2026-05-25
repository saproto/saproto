<?php

namespace App\Console\Commands;

use App\Models\CodexSong;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Replace all triple question marks with quotes in codex song texts.')]
#[Signature('proto:codexsongcleanup')]
class ReplaceQuestionMarkWithSingleQuoteInCodex extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // foreach codex song loop through the lyrics and replace all triple question marks with quotes
        $songs = CodexSong::all();
        foreach ($songs as $song) {
            $song->lyrics = str_replace('???', "'", $song->lyrics);
            $song->save();
        }
    }
}
