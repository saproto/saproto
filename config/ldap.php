<?php

return [
    'proxy' => [
        'utwente' => [
            'url' => env('LDAP_PROXY_URL'),
            'post_url' => env('POST_LDAP_PROXY_URL'),
            'key' => env('LDAP_PROXY_KEY'),
        ],
    ],
];
