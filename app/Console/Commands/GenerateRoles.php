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
        $permissions['omnomcom'] = Permission::where('name', '=', 'omnomcom')->first();
        if ($permissions['omnomcom'] == null) {
            $permissions['omnomcom'] = new Permission(array('name' => 'omnomcom', 'display_name' => 'OmNomCom', 'description' => 'Allows access to the OmNomCom administration.'));
            $permissions['omnomcom']->save();
            $this->info('Added omnomcom permission.');
        }
        $permissions['finadmin'] = Permission::where('name', '=', 'finadmin')->first();
        if ($permissions['finadmin'] == null) {
            $permissions['finadmin'] = new Permission(array('name' => 'finadmin', 'display_name' => 'Financial Administration', 'description' => 'Allows access to the financial administration.'));
            $permissions['finadmin']->save();
            $this->info('Added finadmin permission.');
        }
        $permissions['pilscie'] = Permission::where('name', '=', 'pilscie')->first();
        if ($permissions['pilscie'] == null) {
            $permissions['pilscie'] = new Permission(array('name' => 'pilscie', 'display_name' => 'PilsCie', 'description' => 'Allows access to the PilsCie tools.'));
            $permissions['pilscie']->save();
            $this->info('Added pilscie permission.');
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
        $roles['omnomcom'] = Role::where('name', '=', 'omnomcom')->first();
        if ($roles['omnomcom'] == null) {
            $roles['omnomcom'] = new Role(array('name' => 'omnomcom', 'display_name' => 'OmNomCom', 'description' => 'Members of the OmNomCom.'));
            $roles['omnomcom']->save();
            $this->info('Added omnomcom role.');
        }
        $roles['pilscie'] = Role::where('name', '=', 'pilscie')->first();
        if ($roles['pilscie'] == null) {
            $roles['pilscie'] = new Role(array('name' => 'pilscie', 'display_name' => 'PilsCie', 'description' => 'Members of the PilsCie.'));
            $roles['pilscie']->save();
            $this->info('Added pilscie role.');
        }

        $this->info('Now all roles and permissions exist.');

        $roles['admin']->perms()->sync(array($permissions['admin']->id, $permissions['board']->id, $permissions['omnomcom']->id, $permissions['finadmin']->id, $permissions['pilscie']->id));
        $this->info('Synced admin role with permissions.');
        $roles['board']->perms()->sync(array($permissions['board']->id, $permissions['omnomcom']->id, $permissions['pilscie']->id));
        $this->info('Synced board role with permissions.');
        $roles['omnomcom']->perms()->sync(array($permissions['omnomcom']->id));
        $this->info('Synced omnomcom role with permissions.');
        $roles['pilscie']->perms()->sync(array($permissions['pilscie']->id));
        $this->info('Synced pilscie role with permissions.');

        $this->info('Fixed required permissions and roles.');

    }
}
