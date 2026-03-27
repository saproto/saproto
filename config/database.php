<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_520_ci',
            'prefix' => '',
            'strict' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
   |--------------------------------------------------------------------------
   | Redis Databases
   |--------------------------------------------------------------------------
   |
   | Redis is an open source, fast, and advanced key-value store that also
   | provides a richer body of commands than a typical key-value system
   | such as Memcached. You may define your connection settings here.
   |
   */

    'redis' => [
        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'predis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'session' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_SESSION_DB', '0'),
        ],

        'clusters' => [
            'redis_cluster' => [
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_1_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_1_PORT', '6379'),
                    'database' => env('REDIS_DB', '1'),
                ],
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_2_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_2_PORT', '6379'),
                    'database' => env('REDIS_DB', '2'),
                ],
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_3_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_3_PORT', '6379'),
                    'database' => env('REDIS_DB', '3'),
                ],
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_4_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_4_PORT', '6379'),
                    'database' => env('REDIS_DB', '4'),
                ],
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_5_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_5_PORT', '6379'),
                    'database' => env('REDIS_DB', '5'),
                ],
                [
                    'url' => env('REDIS_URL'),
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_CLUSTER_6_PASSWORD'),
                    'port' => env('REDIS_CLUSTER_6_PORT', '6379'),
                    'database' => env('REDIS_DB', '6'),
                ],
            ],
        ],
    ],
];
