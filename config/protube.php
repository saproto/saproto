<?php

return [

    /*
    | Protube server URL and secret
    */

    'server' => env('PROTUBE_SERVER'),
    'secret' => env('PROTUBE_SHARED_SECRET'),
    'laravel_secret' => env('PROTUBE_LARAVEL_SECRET'),
    'remote_url' => env('PROTUBE_REMOTE_URL', 'https://protu.be/remote'),
];
