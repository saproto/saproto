<?php

return [

    'proxy' => [
        'utwente' => [
            'url' => getenv('LDAP_PROXY_URL'),
            'key' => getenv('LDAP_PROXY_KEY')
        ]
    ]

];
