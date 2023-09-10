<?php

namespace App\Console\Commands;

use App\Models\CodexText;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CodexMarkdownConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:codex-markdown-converter';

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
        foreach(CodexText::all() as $text){
            $oldText= str_replace('//', '_', $text->text);
            while(str_contains($oldText, '==')&&str_contains($oldText, '/=')){
                $between = substr($oldText, strpos($oldText, '==')+2, strpos($oldText, '/=')-strpos($oldText, '==')-2);
                $newBetween= "1. ".str_replace(PHP_EOL, PHP_EOL."1. ", $between);
                $oldText = str_replace("==".$between."/=", $newBetween, $oldText);
            }
            $text->text = $oldText;
            $text->save();
        }
    }
}
