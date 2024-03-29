<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | The Laravel queue API supports a variety of back-ends via an unified
    | API, giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the default queue driver.
    |
    | Supported: "null", "sync", "database", "beanstalkd",
    |            "sqs", "iron", "redis"
    |
    */

    'default' => env('QUEUE_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    */

    'connections' => [
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'backoff' => 30,
        ],
        'high' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'high',
            'backoff' => 30,
        ],
        'medium' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'medium',
            'backoff' => 60,
        ],
        'low' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'low',
            'backoff' => 120,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'driver' => 'database-uuids',
        'database' => env('DB_CONNECTION'),
        'table' => 'failed_jobs',
    ],

];
