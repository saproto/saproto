<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class HomeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws Throwable
     */
    public function testHome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('homepage')
                    ->assertPathIs('/');
        });
    }
}
