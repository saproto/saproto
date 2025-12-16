<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Nominatim implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::CONNECT, [
            'https://nominatim.openstreetmap.org/search',
        ]);

        $policy->add(Directive::IMG, [
            'https://tile.openstreetmap.org',
        ]);
    }
}
