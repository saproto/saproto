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
            $permissions['admin'] = new Permission(array('name' => 'admin', 'display_name' => 'Root', 'description' => 'Gives root access to the application.'));
            $permissions['admin']->save();
            $this->info('Added admin permission.');
        }
        $permissions['board'] = Permission::where('name', '=', 'board')->first();
        if ($permissions['board'] == null) {
            $permissions['board'] = new Permission(array('name' => 'board', 'display_name' => 'Board Access', 'description' => 'Gives access to the association administration.'));
            $permissions['board']->save();
            $this->info('Added board permission.');
        }
        $permissions['omnomcom'] = Permission::where('name', '=', 'omnomcom')->first();
        if ($permissions['omnomcom'] == null) {
            $permissions['omnomcom'] = new Permission(array('name' => 'omnomcom', 'display_name' => 'OmNomCom Access', 'description' => 'Gives access to the OmNomCom administration.'));
            $permissions['omnomcom']->save();
            $this->info('Added omnomcom permission.');
        }
        $permissions['finadmin'] = Permission::where('name', '=', 'finadmin')->first();
        if ($permissions['finadmin'] == null) {
            $permissions['finadmin'] = new Permission(array('name' => 'finadmin', 'display_name' => 'Financial Administration', 'description' => 'Gives access to the financial administration.'));
            $permissions['finadmin']->save();
            $this->info('Added finadmin permission.');
        }
        $permissions['pilscie'] = Permission::where('name', '=', 'pilscie')->first();
        if ($permissions['pilscie'] == null) {
            $permissions['pilscie'] = new Permission(array('name' => 'pilscie', 'display_name' => 'PilsCie Access', 'description' => 'Gives access to the PilsCie tools.'));
            $permissions['pilscie']->save();
            $this->info('Added pilscie permission.');
        }
        $permissions['alfred'] = Permission::where('name', '=', 'alfred')->first();
        if ($permissions['alfred'] == null) {
            $permissions['alfred'] = new Permission(array('name' => 'alfred', 'display_name' => 'Alfred\'s Workshop', 'description' => 'Manages access to the OmNomCom for workshop functions.'));
            $permissions['alfred']->save();
            $this->info('Added alfred permission.');
        }

        $roles['admin'] = Role::where('name', '=', 'admin')->first();
        if ($roles['admin'] == null) {
            $roles['admin'] = new Role(array('name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Application administrator'));
            $roles['admin']->save();
            $this->info('Added admin role.');
        }
        $roles['board'] = Role::where('name', '=', 'board')->first();
        if ($roles['board'] == null) {
            $roles['board'] = new Role(array('name' => 'board', 'display_name' => 'Board', 'description' => 'Association board'));
            $roles['board']->save();
            $this->info('Added board role.');
        }
        $roles['omnomcom'] = Role::where('name', '=', 'omnomcom')->first();
        if ($roles['omnomcom'] == null) {
            $roles['omnomcom'] = new Role(array('name' => 'omnomcom', 'display_name' => 'OmNomCom', 'description' => 'OmNomCom member'));
            $roles['omnomcom']->save();
            $this->info('Added omnomcom role.');
        }
        $roles['finadmin'] = Role::where('name', '=', 'finadmin')->first();
        if ($roles['finadmin'] == null) {
            $roles['finadmin'] = new Role(array('name' => 'finadmin', 'display_name' => 'Financial Administrator', 'description' => 'Finance responsible'));
            $roles['finadmin']->save();
            $this->info('Added finadmin role.');
        }
        $roles['pilscie'] = Role::where('name', '=', 'pilscie')->first();
        if ($roles['pilscie'] == null) {
            $roles['pilscie'] = new Role(array('name' => 'pilscie', 'display_name' => 'PilsCie', 'description' => 'PilsCie member'));
            $roles['pilscie']->save();
            $this->info('Added pilscie role.');
        }
        $roles['pilscie'] = Role::where('name', '=', 'pilscie')->first();
        if ($roles['pilscie'] == null) {
            $roles['pilscie'] = new Role(array('name' => 'pilscie', 'display_name' => 'PilsCie', 'description' => 'PilsCie member'));
            $roles['pilscie']->save();
            $this->info('Added pilscie role.');
        }
        $roles['alfred'] = Role::where('name', '=', 'alfred')->first();
        if ($roles['alfred'] == null) {
            $roles['alfred'] = new Role(array('name' => 'alfred', 'display_name' => 'Alfred', 'description' => 'This person is Alfred'));
            $roles['alfred']->save();
            $this->info('Added alfred role.');
        }

        $this->info('Now all roles and permissions exist.');

        $roles['admin']->perms()->sync(array($permissions['admin']->id, $permissions['board']->id, $permissions['omnomcom']->id, $permissions['finadmin']->id, $permissions['pilscie']->id));
        $this->info('Synced admin role with permissions.');
        $roles['board']->perms()->sync(array($permissions['board']->id, $permissions['omnomcom']->id, $permissions['pilscie']->id));
        $this->info('Synced board role with permissions.');
        $roles['finadmin']->perms()->sync(array($permissions['finadmin']->id));
        $this->info('Synced finadmin role with permissions.');
        $roles['omnomcom']->perms()->sync(array($permissions['omnomcom']->id));
        $this->info('Synced omnomcom role with permissions.');
        $roles['pilscie']->perms()->sync(array($permissions['pilscie']->id));
        $this->info('Synced pilscie role with permissions.');
        $roles['alfred']->perms()->sync(array($permissions['alfred']->id, $permissions['omnomcom']->id));
        $this->info('Synced alfred role with permissions.');

        $this->info('Fixed required permissions and roles.');

    }
}
