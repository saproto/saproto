<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
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

    }
}
