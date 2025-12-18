<?php

namespace App\Csp\Presets;

use Illuminate\Support\Facades\App;
use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class Websockets implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::CONNECT, [
            'https://websockets.saproto.nl:*',
            'ws://websockets.saproto.nl:*',
            'wss://websockets.saproto.nl:*',
            'ws://localhost:3000',
        ]);

        if (App::environment('local')) {
            $policy->add(Directive::CONNECT,
                [
                    'wss://soketi:6001',
                    'ws://soketi:6001',
                    'ws://localhost:*',
                    'http://localhost:*',
                    'ws://127.0.0.1:*',
                ]);
        }
    }
}
