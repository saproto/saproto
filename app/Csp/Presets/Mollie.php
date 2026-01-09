<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Mollie implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::FORM_ACTION, [
            'https://www.mollie.com/checkout/',
        ]);
    }
}
