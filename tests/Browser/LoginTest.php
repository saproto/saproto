<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     * @throws Throwable
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login::show')
                    ->type('email', self::$testUser->email)
                    ->type('password', 'test')
                    ->press('.btn[type="submit"]')
                    ->assertPathIs('/');
        });
    }
}
