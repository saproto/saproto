<?php

namespace App\Csp\Presets;

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
            'https://static.saproto.com'
        ]);
        $policy->add(Directive::MEDIA, [
            'https://static.saproto.com']);

        //allow inline svgs and blobs
        $policy->add(Directive::IMG, [
            'data:'
        ]);

        $policy->add(Directive::FORM_ACTION, Config::array('proto.domains.protube'));
    }
}
