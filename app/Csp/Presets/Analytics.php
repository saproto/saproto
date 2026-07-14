<?php

namespace App\Csp\Presets;

use Illuminate\Support\Facades\Config;
use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Analytics implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add([Directive::CONNECT, Directive::SCRIPT], [
            Config::string('proto.analytics_url')
        ]);
    }
}
