<?php

use App\Csp\Presets\StickerMap;
use App\Csp\Presets\Websockets;
use App\Support\LaravelViteNonceGenerator;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Presets\GoogleFonts;
use Spatie\Csp\Presets\GoogleRecaptcha;
use Spatie\Csp\Presets\JsDelivr;

return [

    /*
     * Presets will determine which CSP headers will be set. A valid CSP preset is
     * any class that implements `Spatie\Csp\Preset`
     */
    'presets' => [
        \App\Csp\Presets\Basic::class,
        GoogleRecaptcha::class,
        JsDelivr::class,
        GoogleFonts::class,
        \Spatie\Csp\Presets\GoogleTlds::class,
        //our own custom presets
        \App\Csp\Presets\Discord::class,
        \App\Csp\Presets\FontAwesome::class,
        \App\Csp\Presets\Mollie::class,
        StickerMap::class,
        \App\Csp\Presets\ProtoApi::class,
        \App\Csp\Presets\ProTube::class,
        \App\Csp\Presets\UtilityScripts::class,
        Websockets::class,
    ],

    /**
     * Register additional global CSP directives here.
     */
    'directives' => [
        [Directive::STYLE, KeyWord::UNSAFE_INLINE],
    ],

    /*
     * These presets which will be put in a report-only policy. This is great for testing out
     * a new policy or changes to existing CSP policy without breaking anything.
     */
    'report_only_presets' => [
        //
    ],

    /**
     * Register additional global report-only CSP directives here.
     */
    'report_only_directives' => [
        // [Directive::SCRIPT, [Keyword::UNSAFE_EVAL, Keyword::UNSAFE_INLINE]],
    ],

    /*
     * All violations against a policy will be reported to this url.
     * A great service you could use for this is https://report-uri.com/
     */
    'report_uri' => env('CSP_REPORT_URI', ''),

    /*
     * Headers will only be added if this setting is set to true.
     */
    'enabled' => env('CSP_ENABLED', true),

    /**
     * Headers will be added when Vite is hot reloading.
     */
    'enabled_while_hot_reloading' => env('CSP_ENABLED_WHILE_HOT_RELOADING', false),

    /*
     * The class responsible for generating the nonces used in inline tags and headers.
     */
    'nonce_generator' => LaravelViteNonceGenerator::class,

    /*
     * Set false to disable automatic nonce generation and handling.
     * This is useful when you want to use 'unsafe-inline' for scripts/styles
     * and cannot add inline nonces.
     * Note that this will make your CSP policy less secure.
     */
    'nonce_enabled' => env('CSP_NONCE_ENABLED', true),
];
