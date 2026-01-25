<?php

namespace App\Csp\Presets;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class ProtoApi implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::CONNECT, [
            // Internal APIs
            'https://proto.utwente.nl',
            'https://www.proto.utwente.nl',
            'https://static.saproto.com',
        ]);
        $policy->add(Directive::MEDIA, [
            'https://static.saproto.com']);

        // allow inline svgs and blobs
        $policy->add(Directive::IMG, [
            'https://lh3.googleusercontent.com',
            'https://static.saproto.com',
            'data:',
        ]);

        if (App::environment('local')) {
            $policy->add(Directive::IMG,
                [
                    'http://laravel.web.garage.localhost:3902',
                ]);
        }

        $policy->add(Directive::FORM_ACTION, Config::array('proto.domains.protube'));
    }
}
