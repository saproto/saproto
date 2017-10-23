<?php

return [

    /*
     * Primary app location
     */

    'primary-domain' => env('PRIMARY_DOMAIN'),
    'app-url' => config('app.url'),

    /*
     * Whitelist for debug environment
     */
    'debug-whitelist' => env('DEV_ALLOWED', null),

    /*
     * Personal Proto key
     */
    'personal-proto-key' => env('PERSONAL_PROTO_KEY', null),

    /*
     * Printer server settings
     */
    'printer-host' => env('PRINTER_HOST'),
    'printer-port' => env('PRINTER_PORT'),
    'printer-secret' => env('PRINTER_SECRET'),

    /*
     * Google API keys
     */
    'google-key-public' => env('GOOGLE_KEY_PUBLIC'),
    'google-key-private' => env('GOOGLE_KEY_PRIVATE'),

    /*
     * Fishcam
     */
    'fishcam-url' => env('FISHCAM_URL'),

    /*
     * UTwente LDAP webhook
     */
    'utwente-ldap-hook' => env('LDAP_URL_UTWENTE', null),

    /*
     * DirectAdmin config
     */
    'directadmin-hostname' => env('DA_HOSTNAME', null),
    'directadmin-port' => env('DA_PORT', null),
    'directadmin-username' => env('DA_USERNAME', null),
    'directadmin-password' => env('DA_PASSWORD', null),
    'directadmin-domain' => env('DA_DOMAIN', null),

    /*
     * Spotify config
     */
    'spotify-clientkey' => env('SPOTIFY_CLIENT', null),
    'spotify-secretkey' => env('SPOTIFY_SECRET', null),
    'spotify-user' => env('SPOTIFY_USER', null),
    'spotify-playlist' => env('SPOTIFY_PLAYLIST', null),

    /*
     * Sentry config
     */
    'sentry-dsn' => env('SENTRY_PUBLIC_DSN', null)

];