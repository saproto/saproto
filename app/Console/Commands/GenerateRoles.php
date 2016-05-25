<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Proto\Models\Permission;
use Proto\Models\Role;

/**
 * TODO
 * Autorelate permissions to roles.
 */
class GenerateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:generateroles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the roles and permissions needed for the application.';

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

        $this->info('Fixing role and permissions structure.');

        $permissions = array();
        $roles = array();

        $permissions['admin'] = Permission::where('name', '=', 'admin')->first();
        if ($permissions['admin'] == null) {
            $permissions['admin'] = new Permission(array('name' => 'admin', 'display_name' => 'Administrative Access', 'description' => 'Has access to application administration.'));
            $permissions['admin']->save();
            $this->info('Added admin permission.');
        }
        $permissions['board'] = Permission::where('name', '=', 'board')->first();
        if ($permissions['board'] == null) {
            $permissions['board'] = new Permission(array('name' => 'board', 'display_name' => 'Board Access', 'description' => 'Has access to association administration.'));
            $permissions['board']->save();
            $this->info('Added board permission.');
        }
        $permissions['bigbrother'] = Permission::where('name', '=', 'bigbrother')->first();
        if ($permissions['bigbrother'] == null) {
            $permissions['bigbrother'] = new Permission(array('name' => 'bigbrother', 'display_name' => 'Big Brother', 'description' => 'Allows to see any privacy-protected information.'));
            $permissions['bigbrother']->save();
            $this->info('Added bigbrother permission.');
        }

        $roles['admin'] = Role::where('name', '=', 'admin')->first();
        if ($roles['admin'] == null) {
            $roles['admin'] = new Role(array('name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrators of this application.'));
            $roles['admin']->save();
            $this->info('Added admin role.');
        }
        $roles['board'] = Role::where('name', '=', 'board')->first();
        if ($roles['board'] == null) {
            $roles['board'] = new Role(array('name' => 'board', 'display_name' => 'Association Board', 'description' => 'Board of the association.'));
            $roles['board']->save();
            $this->info('Added board role.');
        }

        $this->info('Now all roles and permissions exist.');

        $roles['admin']->perms()->sync(array($permissions['admin']->id, $permissions['board']->id, $permissions['bigbrother']->id));
        $this->info('Synced admin role with permissions.');
        $roles['board']->perms()->sync(array($permissions['board']->id, $permissions['bigbrother']->id));
        $this->info('Synced board role with permissions.');

        $this->info('Fixed required permissions and roles.');

    }
}
