<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    |
    | Laravel supports both SMTP and PHP's "mail" function as drivers for the
    | sending of e-mail. You may specify which one you're using throughout
    | your application here. By default, Laravel is setup for SMTP mail.
    |
    | Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "ses", "log"
    |
    */

    'driver' => env('MAIL_DRIVER', 'log'),
    'host' => 'localhost',
    'port' => 25,
    'encryption' => false,
    'username' => env('SMTP_USERNAME'),
    'password' => env('SMTP_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => ['address' => 'webmaster@proto.utwente.nl', 'name' => 'S.A. Proto Webmaster'],

];
