<?php

namespace Tests;

use Illuminate\Database\SQLiteConnection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Override;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();

        if (DB::connection() instanceof SQLiteConnection) {
            $db = DB::connection()->getPdo();

            // Fix SqLite not having the FROM_UNIXTIME function
            $db->sqliteCreateFunction('FROM_UNIXTIME', fn ($value) => date('Y-m-d H:i:s', $value));

            // Fix SqLite not having the YEAR function
            $db->sqliteCreateFunction('YEAR', fn ($value) => date('Y', strtotime((string) $value)));
        }

    }
}
