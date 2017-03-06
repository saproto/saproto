<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = 'Play sound through Herbert on Petra-playout.';

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
     * @return mixed
     */
    public function handle()
    {
        file_get_contents(env('HERBERT_SERVER') . '/soundboard?secret=' . env('HERBERT_SECRET') . '&sound=' . $this->argument('sound'));
        $this->info("Playing sound.");
    }
}
