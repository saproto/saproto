<?php

namespace Proto\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Exceptions\InvalidDirective;
use Spatie\Csp\Exceptions\InvalidValueSet;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

use function Sentry\captureException;

class ProtoPolicy extends Policy
{
    public function configure()
    {
        try {
            $this
                ->addDirective(Directive::BASE, Keyword::SELF)
                ->addDirective(Directive::DEFAULT, Keyword::SELF)
                ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
                ->addDirective(Directive::OBJECT, Keyword::NONE)
                ->addDirective(Directive::SCRIPT, [
                    Keyword::SELF,
                    'https://discordapp.com/api/guilds/600338792766767289/widget.json',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.aff',
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.dic',
                    'https://analytics.saproto.nl/piwik.js',
                    'https://www.youtube.com/iframe_api',
                    'https://s.ytimg.com'
                ])
                ->addNonceForDirective(Directive::SCRIPT)
                ->addDirective(Directive::STYLE, [
                    Keyword::SELF,
                    Keyword::UNSAFE_INLINE,
                    'https://fonts.googleapis.com/css'
                ])
                ->addDirective(Directive::IMG, [
                    Keyword::SELF,
                    '*',
                    'data:'
                ])
                ->addDirective(Directive::MEDIA, [
                    Keyword::SELF,
                    'https://static.saproto.com'
                ])
                ->addDirective(Directive::FRAME, [
                    Keyword::SELF,
                    'https://www.youtube.com/embed',
                    'https://www.google.com/recaptcha/',
                    'https://recaptcha.google.com/recaptcha/'
                ])
                ->addDirective(Directive::FONT, [
                    Keyword::SELF,
                    'data:',
                    'https://fonts.gstatic.com'
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
                    'https://cdn.jsdelivr.net/codemirror.spell-checker/latest/en_US.dic'
                ]);
        } catch (InvalidDirective $e) {
            captureException($e);
        } catch (InvalidValueSet $e) {
            captureException($e);
        }
    }
}