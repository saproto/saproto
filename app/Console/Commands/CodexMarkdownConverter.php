<?php

namespace App\Console\Commands;

use App\Models\CodexSong;
use App\Models\CodexText;
use Illuminate\Console\Command;

class CodexMarkdownConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:codex-markdown-converter';

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
        foreach (CodexText::all() as $text) {
            $text->text = $this->reformat($text->text);
            $text->save();
        }

        foreach (CodexSong::all() as $song) {
            $song->lyrics = $this->reformat($song->lyrics);
            $song->save();
        }
    }

    private function reformat(string $text): string
    {
        $text = str_replace('ÃŸ', mb_convert_encoding('ß', 'UTF-8', 'ISO-8859-1'), $text);
        $text = str_replace('//', '_', $text);
        $text = str_replace('`', "\'", $text);
        while (str_contains($text, '==') && str_contains($text, '/=')) {
            $between = substr($text, strpos($text, '==') + 2, strpos($text, '/=') - strpos($text, '==') - 2);
            $newBetween = '1. '.str_replace(PHP_EOL, PHP_EOL.'1. ', $between);
            $text = str_replace('=='.$between.'/=', $newBetween, $text);
        }

        return mb_convert_encoding($text, 'ISO-8859-1');
    }
}
