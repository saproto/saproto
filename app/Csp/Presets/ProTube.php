<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class ProTube implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::FRAME, [
            'https://protu.be/'
        ]);
    }
}

