<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | This array stores the connections that are added to Adldap. You can add
    | as many connections as you like.
    |
    | The key is the name of the connection you wish to use and the value is
    | an array of configuration settings.
    |
    */

    'proto' => [
        'account_prefix' => '',
        'account_suffix' => '@ad.saproto.nl',
        'domain_controllers' => ['ad.proto.utwente.nl'],
        'port' => 636,
        'timeout' => 5,
        'base_dn' => 'OU=Proto,DC=ad,DC=saproto,DC=nl',
        'admin_account_suffix' => '@ad.saproto.nl',
        'admin_username' => env('LDAP_PROTO_ADMIN_USER'),
        'admin_password' => env('LDAP_PROTO_ADMIN_PASS'),
        'follow_referrals' => false,
        'use_ssl' => true,
        'use_tls' => false,
    ],

];
