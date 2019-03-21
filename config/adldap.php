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
        'account_suffix' => env('LDAP_PROTO_SUFFIX'),
        'domain_controllers' => [env('LDAP_PROTO_SERVER')],
        'port' => 636,
        'timeout' => 5,
        'base_dn' => env('LDAP_PROTO_BASE_DN'),
        'admin_account_suffix' => env('LDAP_PROTO_SUFFIX'),
        'admin_username' => env('LDAP_PROTO_ADMIN_USER'),
        'admin_password' => env('LDAP_PROTO_ADMIN_PASS'),
        'follow_referrals' => false,
        'use_ssl' => true,
        'use_tls' => false,
    ],

    'utwente' => [
        'account_prefix' => '',
        'account_suffix' => env('LDAP_UTWENTE_SUFFIX'),
        'domain_controllers' => [env('LDAP_UTWENTE_SERVER')],
        'port' => 636,
        'timeout' => 5,
        'base_dn' => env('LDAP_UTWENTE_BASE_DN'),
        'admin_account_suffix' => env('LDAP_UTWENTE_SUFFIX'),
        'admin_username' => env('LDAP_UTWENTE_ADMIN_USER'),
        'admin_password' => env('LDAP_UTWENTE_ADMIN_PASS'),
        'follow_referrals' => false,
        'use_ssl' => true,
        'use_tls' => false,
    ],

];
