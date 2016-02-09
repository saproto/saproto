<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Proto\Models\Role;

class AddRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds role to user.';

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
        $role = new Role();
        $role->name = $this->argument('role');
        $role->display_name = $this->ask('Display name?');
        $role->description = $this->ask('Description?');
        if($this->confirm("Continue? [y/N]")) {
            $role->save();
            $this->info('Done.');
        }else{
            $this->error('Aborted.');
        }
    }
}
