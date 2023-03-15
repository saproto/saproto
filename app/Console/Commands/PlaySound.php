<?php

namespace Proto\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PlaySound extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:playsound {sound}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play sound through ProTube';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $sound = '&sound='.$this->argument('sound');
            Http::get(config('protube.server').'/soundboard?secret='.config('protube.secret').$sound);
            $this->info('Playing sound.');
        } catch (Exception $e) {
            $this->error('Could not find ProTube:', $e->getMessage());
        }
    }
}
