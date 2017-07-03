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
            'client_id' => getenv('FLICKR_CLIENT'),
            'client_secret' => getenv('FLICKR_SECRET')
        ],

    ]

];