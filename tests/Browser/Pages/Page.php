<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page as BasePage;
use Override;

abstract class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array<string, string>
     */
    #[Override]
    public static function siteElements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
