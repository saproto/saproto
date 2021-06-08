<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateRoles extends Command
{
    protected $signature = 'proto:generateroles';
    protected $description = 'Generate the roles and permissions needed for the application.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Fixing role and permissions structure.');

        /** @var Permission[] $permissions */
        $permissions = [];
        /** @var Role[] $roles */
        $roles = [];

        foreach(config('permission.permissions') as $name => $permission) {
            $permissions[$name] =
                Permission::where('name', $name)->first() ??
                Permission::create([
                    'name' => $name,
                    'display_name' => $permission->display_name,
                    'description' => $permission->description
                ]);
            $this->info("Added $name permission.");
        }

        foreach(config('permission.roles') as $name => $role) {
            $roles[$name] =
                Role::where('name', $name)->first() ??
                Role::create([
                    'name' => $name,
                    'display_name' => $role->display_name,
                    'description' => $role->description
                ]);
            $this->info("Added $name role.");
            if($role->permissions == '*')
                $roles[$name]->syncPermissions(array_keys(config('permission.permissions')));
            else
                $roles[$name]->syncPermissions($role->permissions);
            $this->info("Synced permissions for $name role.");
        }

        $this->info('Fixed required permissions and roles.');

    }
}
