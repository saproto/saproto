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

        $permissions = [];
        $roles = [];

        $permissions['sysadmin'] = Permission::where('name', '=', 'sysadmin')->first();
        if ($permissions['sysadmin'] == null) {
            $permissions['sysadmin'] = new Permission(['name' => 'sysadmin', 'display_name' => 'System Admin', 'description' => 'Gives admin access to the application.']);
            $permissions['sysadmin']->save();
            $this->info('Added sysadmin permission.');
        }
        $permissions['board'] = Permission::where('name', '=', 'board')->first();
        if ($permissions['board'] == null) {
            $permissions['board'] = new Permission(['name' => 'board', 'display_name' => 'Board Access', 'description' => 'Gives access to the association administration.']);
            $permissions['board']->save();
            $this->info('Added board permission.');
        }
        $permissions['protube'] = Permission::where('name', '=', 'protube')->first();
        if ($permissions['protube'] == null) {
            $permissions['protube'] = new Permission(['name' => 'protube', 'display_name' => 'Protube Admin', 'description' => 'Gives Protube admin access.']);
            $permissions['protube']->save();
            $this->info('Added protube permission.');
        }
        $permissions['omnomcom'] = Permission::where('name', '=', 'omnomcom')->first();
        if ($permissions['omnomcom'] == null) {
            $permissions['omnomcom'] = new Permission(['name' => 'omnomcom', 'display_name' => 'OmNomCom Access', 'description' => 'Gives access to the OmNomCom administration.']);
            $permissions['omnomcom']->save();
            $this->info('Added omnomcom permission.');
        }
        $permissions['finadmin'] = Permission::where('name', '=', 'finadmin')->first();
        if ($permissions['finadmin'] == null) {
            $permissions['finadmin'] = new Permission(['name' => 'finadmin', 'display_name' => 'Financial Administration', 'description' => 'Gives access to the financial administration.']);
            $permissions['finadmin']->save();
            $this->info('Added finadmin permission.');
        }
        $permissions['tipcie'] = Permission::where('name', '=', 'tipcie')->first();
        if ($permissions['tipcie'] == null) {
            $permissions['tipcie'] = new Permission(['name' => 'tipcie', 'display_name' => 'TIPCie Access', 'description' => 'Gives access to the TIPCie tools.']);
            $permissions['tipcie']->save();
            $this->info('Added tipcie permission.');
        }
        $permissions['drafters'] = Permission::where('name', '=', 'drafters')->first();
        if ($permissions['drafters'] == null) {
            $permissions['drafters'] = new Permission(['name' => 'drafters', 'display_name' => 'Guild of Drafters Access', 'description' => 'Gives access to the relevant tools for drafters.']);
            $permissions['drafters']->save();
            $this->info('Added drafters permission.');
        }
        $permissions['alfred'] = Permission::where('name', '=', 'alfred')->first();
        if ($permissions['alfred'] == null) {
            $permissions['alfred'] = new Permission(['name' => 'alfred', 'display_name' => 'Alfred\'s Workshop', 'description' => 'Manages access to the OmNomCom for workshop functions.']);
            $permissions['alfred']->save();
            $this->info('Added alfred permission.');
        }
        $permissions['header-image'] = Permission::where('name', '=', 'header-image')->first();
        if ($permissions['header-image'] == null) {
            $permissions['header-image'] = new Permission(['name' => 'header-image', 'display_name' => 'Update Header Image', 'description' => 'Allows updating the site\'s header images.']);
            $permissions['header-image']->save();
            $this->info('Added header-image permission.');
        }
        $permissions['protography'] = Permission::where('name', '=', 'protography')->first();
        if ($permissions['protography'] == null) {
            $permissions['protography'] = new Permission(['name' => 'protography', 'display_name' => 'Photo Acess', 'description' => 'Allows managing photos and albums.']);
            $permissions['protography']->save();
            $this->info('Added protography permission.');
        }
        $permissions['publishalbums'] = Permission::where('name', '=', 'publishalbums')->first();
        if ($permissions['publishalbums'] == null) {
            $permissions['publishalbums'] = new Permission(['name' => 'publishalbums', 'display_name' => 'Publish Albums', 'description' => 'Allows publishing photo albums.']);
            $permissions['publishalbums']->save();
            $this->info('Added publishalbums permission.');
        }
        $permissions['registermembers'] = Permission::where('name', '=', 'registermembers')->first();
        if ($permissions['registermembers'] == null) {
            $permissions['registermembers'] = new Permission(['name' => 'registermembers', 'display_name' => 'Register Members', 'description' => 'Allows completing new member registrations.']);
            $permissions['registermembers']->save();
            $this->info('Added registermembers permission.');
        }

        $roles['sysadmin'] = Role::where('name', '=', 'sysadmin')->first();
        if ($roles['sysadmin'] == null) {
            $roles['sysadmin'] = new Role(['name' => 'sysadmin', 'display_name' => 'System Administrator', 'description' => 'System administrator']);
            $roles['sysadmin']->save();
            $this->info('Added sysadmin role.');
        }
        $roles['admin'] = Role::where('name', '=', 'admin')->first();
        if ($roles['admin'] == null) {
            $roles['admin'] = new Role(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Application administrator']);
            $roles['admin']->save();
            $this->info('Added admin role.');
        }
        $roles['protube'] = Role::where('name', '=', 'protube')->first();
        if ($roles['protube'] == null) {
            $roles['protube'] = new Role(['name' => 'protube', 'display_name' => 'Protube', 'description' => 'Protube administration']);
            $roles['protube']->save();
            $this->info('Added protube role.');
        }
        $roles['board'] = Role::where('name', '=', 'board')->first();
        if ($roles['board'] == null) {
            $roles['board'] = new Role(['name' => 'board', 'display_name' => 'Board', 'description' => 'Association board']);
            $roles['board']->save();
            $this->info('Added board role.');
        }
        $roles['omnomcom'] = Role::where('name', '=', 'omnomcom')->first();
        if ($roles['omnomcom'] == null) {
            $roles['omnomcom'] = new Role(['name' => 'omnomcom', 'display_name' => 'OmNomCom', 'description' => 'OmNomCom member']);
            $roles['omnomcom']->save();
            $this->info('Added omnomcom role.');
        }
        $roles['finadmin'] = Role::where('name', '=', 'finadmin')->first();
        if ($roles['finadmin'] == null) {
            $roles['finadmin'] = new Role(['name' => 'finadmin', 'display_name' => 'Financial Administrator', 'description' => 'Finance responsible']);
            $roles['finadmin']->save();
            $this->info('Added finadmin role.');
        }
        $roles['tipcie'] = Role::where('name', '=', 'tipcie')->first();
        if ($roles['tipcie'] == null) {
            $roles['tipcie'] = new Role(['name' => 'tipcie', 'display_name' => 'TIPCie', 'description' => 'TIPCie member']);
            $roles['tipcie']->save();
            $this->info('Added tipcie role.');
        }
        $roles['drafters'] = Role::where('name', '=', 'drafters')->first();
        if ($roles['drafters'] == null) {
            $roles['drafters'] = new Role(['name' => 'drafters', 'display_name' => 'Guild of Drafters', 'description' => 'Guild of Drafters member']);
            $roles['drafters']->save();
            $this->info('Added drafters role.');
        }
        $roles['alfred'] = Role::where('name', '=', 'alfred')->first();
        if ($roles['alfred'] == null) {
            $roles['alfred'] = new Role(['name' => 'alfred', 'display_name' => 'Alfred', 'description' => 'This person is Alfred']);
            $roles['alfred']->save();
            $this->info('Added alfred role.');
        }
        $roles['protography-admin'] = Role::where('name', '=', 'protography-admin')->first();
        if ($roles['protography-admin'] == null) {
            $roles['protography-admin'] = new Role(['name' => 'protography-admin', 'display_name' => 'Protography Admin', 'description' => 'Manages certain photographic aspects']);
            $roles['protography-admin']->save();
            $this->info('Added protography-admin role.');
        }
        $roles['protography'] = Role::where('name', '=', 'protography')->first();
        if ($roles['protography'] == null) {
            $roles['protography'] = new Role(['name' => 'protography', 'display_name' => 'Protography', 'description' => 'Protography member']);
            $roles['protography']->save();
            $this->info('Added protography role.');
        }
        $roles['registration-helper'] = Role::where('name', '=', 'registration-helper')->first();
        if ($roles['registration-helper'] == null) {
            $roles['registration-helper'] = new Role(['name' => 'registration-helper', 'display_name' => 'Registration Helper', 'description' => 'Helper during the kick-in member registration session.']);
            $roles['registration-helper']->save();
            $this->info('Added registration-helper role.');
        }

        $this->info('Now all roles and permissions exist.');

        $roles['sysadmin']->perms()->sync([$permissions['sysadmin']->id, $permissions['board']->id, $permissions['omnomcom']->id, $permissions['finadmin']->id, $permissions['tipcie']->id, $permissions['protube']->id, $permissions['drafters']->id, $permissions['header-image']->id, $permissions['protography']->id, $permissions['publishalbums']->id, $permissions['registermembers']->id]);
        $this->info('Synced sysadmin role with permissions.');
        $roles['admin']->perms()->sync([$permissions['board']->id, $permissions['omnomcom']->id, $permissions['finadmin']->id, $permissions['tipcie']->id, $permissions['protube']->id, $permissions['drafters']->id, $permissions['header-image']->id, $permissions['protography']->id, $permissions['publishalbums']->id, $permissions['registermembers']->id]);
        $this->info('Synced admin role with permissions.');
        $roles['protube']->perms()->sync([$permissions['protube']->id]);
        $this->info('Synced admin role with permissions.');
        $roles['board']->perms()->sync([$permissions['board']->id, $permissions['omnomcom']->id, $permissions['tipcie']->id, $permissions['protube']->id, $permissions['drafters']->id, $permissions['registermembers']->id]);
        $this->info('Synced board role with permissions.');
        $roles['finadmin']->perms()->sync([$permissions['finadmin']->id]);
        $this->info('Synced finadmin role with permissions.');
        $roles['omnomcom']->perms()->sync([$permissions['omnomcom']->id]);
        $this->info('Synced omnomcom role with permissions.');
        $roles['tipcie']->perms()->sync([$permissions['tipcie']->id, $permissions['drafters']->id, $permissions['omnomcom']->id]);
        $this->info('Synced tipcie role with permissions.');
        $roles['drafters']->perms()->sync([$permissions['drafters']->id]);
        $this->info('Synced drafters role with permissions.');
        $roles['alfred']->perms()->sync([$permissions['alfred']->id, $permissions['omnomcom']->id]);
        $this->info('Synced alfred role with permissions.');
        $roles['protography-admin']->perms()->sync([$permissions['header-image']->id, $permissions['protography']->id, $permissions['publishalbums']->id]);
        $this->info('Synced protography-admin role with permissions.');
        $roles['protography']->perms()->sync([$permissions['protography']->id]);
        $this->info('Synced protography role with permissions.');
        $roles['registration-helper']->perms()->sync([$permissions['registermembers']->id]);
        $this->info('Synced registration-helper role with permissions');

        $this->info('Fixed required permissions and roles.');
    }
}
