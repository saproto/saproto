<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],
        'stack' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),
            'port' => env('SFTP_PORT', 22),
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),
            'root' => env('SFTP_ROOT', 'photo_storage'),
        ],

        'stack_backup' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),
            'port' => env('SFTP_PORT', 22),
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),
            'root' => env('SFTP_ROOT_BACKUP', 'laravel_backup'),
        ],

        'garage' => [
            'driver' => env('GARAGE_DRIVER', 's3'),
            'key'    => env('GARAGE_KEY'),
            'secret' => env('GARAGE_SECRET'),
            'region' => env('GARAGE_REGION'),
            'bucket' => env('GARAGE_BUCKET'),
            'endpoint' => env('GARAGE_ENDPOINT'),
            'use_path_style_endpoint' => env('GARAGE_USE_PATH_STYLE', true),
            'throw' => true,
            'url' => env('GARAGE_WEB_URL'),
        ],
    ],
    /*
     |--------------------------------------------------------------------------
     | Symbolic Links
     |--------------------------------------------------------------------------
     |
     | Here you may configure the symbolic links that will be created when the
     | `storage:link` Artisan command is executed. The array keys should be
     | the locations of the links and the values should be their targets.
     |
     */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
