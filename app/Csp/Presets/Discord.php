<?php

namespace App\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Discord implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::CONNECT, [
            'https://discordapp.com/api/guilds/600338792766767289/widget.json',
        ]);
    }
}
