<?php

// https://upgrade.yubico.com/getapikey/

return array(

    'CLIENT_ID' => env('UBIKEY_CLIENT'),

    'SECRET_KEY' => env('UBIKEY_SECRET'),

    'URL_LIST' => array(
        'api.yubico.com/wsapi/2.0/verify',
        'api2.yubico.com/wsapi/2.0/verify',
        'api3.yubico.com/wsapi/2.0/verify',
        'api4.yubico.com/wsapi/2.0/verify',
        'api5.yubico.com/wsapi/2.0/verify',
    ),

    'USER_AGENT' => 'S.A. Proto / Laravel 5',

);
