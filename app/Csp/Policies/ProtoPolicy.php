<?php

namespace App\Csp\Policies;

use Illuminate\Support\Facades\App;
use Spatie\Csp\Directive;
use Spatie\Csp\Exceptions\InvalidDirective;
use Spatie\Csp\Exceptions\InvalidValueSet;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

use function Sentry\captureException;

class ProtoPolicy extends Policy
{
    public function configure(): void
    {
        try {
            $this
                ->addDirective(Directive::BASE, Keyword::SELF)
                ->addDirective(Directive::DEFAULT, Keyword::SELF)
                ->addDirective(Directive::FORM_ACTION, [
                    Keyword::SELF,
                    'https://www.mollie.com/checkout/',
                    'https://wrapped.omnomcom.nl',
                    ...config('proto.domains.protube'),
                    ...(App::environment('production') ? [] : ['http://localhost:*']),
                ])
                ->addDirective(Directive::OBJECT, Keyword::NONE)
                ->addDirective(Directive::SCRIPT, [
                    Keyword::SELF,
                    'https://discordapp.com/api/guilds/600338792766767289/widget.json',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.aff',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.dic',
                    'https://analytics.saproto.nl/matomo.js',
                    'https://www.youtube.com/iframe_api',
                    'https://s.ytimg.com',
                    'https://www.google.com/recaptcha/api.js',
                    'blob:',
                    'https://ka-f.fontawesome.com/',
                    ...([config('proto.fontawesome_kit')] ?? []),  // Avoid adding empty string or null.
                    ...(App::environment('production') ? [] : ['http://localhost:*']),
                ])
                ->addNonceForDirective(Directive::SCRIPT)
                ->addDirective(Directive::STYLE, [
                    Keyword::SELF,
                    Keyword::UNSAFE_INLINE,
                    'https://fonts.googleapis.com/css',
                    ...(App::environment('production') ? [] : ['http://localhost:*']),
                ])
                ->addDirective(Directive::IMG, [
                    Keyword::SELF,
                    '*',
                    'data:',
                ])
                ->addDirective(Directive::MEDIA, [
                    Keyword::SELF,
                    '*',
                    'https://static.saproto.com',
                ])
                ->addDirective(Directive::FRAME, [
                    Keyword::SELF,
                    'https://www.youtube.com/embed/',
                    'https://www.google.com/recaptcha/',
                    'https://recaptcha.google.com/recaptcha/',
                ])
                ->addDirective(Directive::FONT, [
                    Keyword::SELF,
                    'data:',
                    'https://fonts.gstatic.com',
                    'https://ka-f.fontawesome.com/',
                ])
                ->addDirective(Directive::CONNECT, [
                    Keyword::SELF,
                    'https://proto.utwente.nl',
                    'https://www.proto.utwente.nl',
                    'https://static.saproto.com',
                    'https://metis.proto.utwente.nl:3001',
                    'wss://metis.proto.utwente.nl:3001',
                    'ws://localhost:3000',
                    'https://discordapp.com/api/guilds/600338792766767289/widget.json',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.aff',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.dic',
                    'https://cdn.jsdelivr.net/npm/chart.js',
                    'https://ka-f.fontawesome.com/',
                    'https://api.fontawesome.com/',
                    ...(App::environment('production') ? [] : ['ws://localhost:*']),
                ]);
        } catch (InvalidValueSet|InvalidDirective $e) {
            captureException($e);
        }
    }
}
