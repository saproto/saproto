<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Models\ProtoInk;

class ProtoInkSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:protoinksync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ProtoInk feed to local database.';

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
        //
    }
}
