<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /** @var Permission[] $permissions */
        $permissions = [];

        foreach (config('permission.permissions') as $name => $permission) {
            $permissions[$name] = Permission::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $permission->display_name,
                    'description' => $permission->description,
                    'guard_name' => $permission->guard_name ?? 'web',
                ]
            );
        }

        foreach (config('permission.roles') as $name => $role) {
            $roles[$name] = Role::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $role->display_name,
                    'description' => $role->description,
                    'guard_name' => $role->guard_name ?? 'web',
                ]
            );
            $roles[$name]->syncPermissions($role->permissions == '*' ? array_keys($permissions) : $role->permissions);
        }
    }
}
