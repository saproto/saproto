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
    protected $signature = 'app:generateroles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the roles needed for the S.A. Proto application.';

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

        $perms = [
            array(
                'name' => 'bigbrother',
                'display' => 'Big Brother',
                'description' => 'Has the permission to see all personal information.'
            ),
            array(
                'name' => 'board',
                'display' => 'Board Permission',
                'description' => 'Has the permission to act as the board.'
            )
        ];

        $roles = [
            array(
                'name' => 'root',
                'display' => 'Have You Tried Turning It Off And On Again committee',
                'description' => 'User is epic and part of the HYTTIOAOAc.',
                'perms' => ['bigbrother', 'board']
            ),
            array(
                'name' => 'admin',
                'display' => 'Board',
                'description' => 'User is in the board.',
                'perms' => ['bigbrother', 'board']
            )
        ];

        foreach ($perms as $perm) {
            $new = new Permission();
            $new->name = $perm['name'];
            $new->display_name = $perm['display'];
            $new->description = $perm['description'];
            try {
                $new->save();
            } catch (\Exception $e) {
                $this->info('Skipping permission ' . $perm['name'] . ".");
            }
        }


        foreach ($roles as $role) {
            $new = new Role();
            $new->name = $role['name'];
            $new->display_name = $role['display'];
            $new->description = $role['description'];
            try {
                $new->save();
            } catch (\Exception $e) {
                $this->info('Skipping role ' . $role['name'] . ".");
            }
        }

        $this->info('Added necessary roles.');
    }
}
