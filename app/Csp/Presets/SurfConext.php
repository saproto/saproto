<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class SurfConext implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::FORM_ACTION, [
            'https://engine.surfconext.nl',
            'https://login.microsoftonline.com',
        ]);
    }
}
