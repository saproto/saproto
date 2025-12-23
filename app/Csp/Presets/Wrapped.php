<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Wrapped implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::IMG, [
            'https://img.youtube.com',
            'https://i.ytimg.com',
        ]);
        $policy->add(Directive::FRAME, [
            'https://www.youtube.com',
        ]);
    }
}
