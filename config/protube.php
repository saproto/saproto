<?php

return [

    /*
    | Protube server URL and secret
    */

    'server' => env('PROTUBE_SERVER'),
    'laravel_to_protube_secret' => env('LARAVEL_TO_PROTUBE_SECRET'),
    'protube_to_laravel_secret' => env('PROTUBE_TO_LARAVEL_SECRET'),
    'remote_url' => env('PROTUBE_REMOTE_URL', 'https://protu.be/remote'),
];
