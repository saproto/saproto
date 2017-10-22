<?php

return [

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     * 'storage' => '\\OAuth\\Common\\Storage\\Session',
     */

    /**
     * Consumers
     */
    'consumers' => [

        'Flickr' => [
            'client_id' => env('FLICKR_CLIENT'),
            'client_secret' => env('FLICKR_SECRET')
        ],

    ]

];