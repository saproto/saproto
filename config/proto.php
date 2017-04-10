<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Root Committee
    |--------------------------------------------------------------------------
    |
    | The slug of the committee that is considered to have admin access to the application.
    | This committee cannot be deleted.
    |
    */

    'rootcommittee' => 'haveyoutriedturningitoffandonagain',
    'rootrole' => 12,

    /*
    |--------------------------------------------------------------------------
    | Primary e-mail domain
    |--------------------------------------------------------------------------
    |
    | This domain will be prefixed to e-mail slugs in order to complete e-mail addresses.
    |
    */

    'emaildomain' => 'proto.utwente.nl',

    /*
    |--------------------------------------------------------------------------
    | Roles that require Two-Factor Authentication
    |--------------------------------------------------------------------------
    |
    | Users that have any of these roles will be forced by the application to enable TFA to enhance security.
    |
    */

    'tfaroles' => ['sysadmin', 'admin', 'board', 'finadmin'],

    /*
    |--------------------------------------------------------------------------
    | Print product
    |--------------------------------------------------------------------------
    |
    | The product that should be used for printing documents on the site.
    |
    */

    'printproduct' => 17,

    /*
    |--------------------------------------------------------------------------
    | Weekly newsletter
    |--------------------------------------------------------------------------
    |
    | The email list ID for the weekly newsletter.
    |
    */

    'weeklynewsletter' => 1,

    /*
    |--------------------------------------------------------------------------
    | Auto subscribe mailinglist
    |--------------------------------------------------------------------------
    |
    | The email list ID's that a user should be subscribed to.
    |
    */

    'autoSubscribeUser' => [],
    'autoSubscribeMember' => [8],

    /*
    |--------------------------------------------------------------------------
    | Public Timetable Calendar
    |--------------------------------------------------------------------------
    |
    | The Google calendar ID for the imported timetable.
    |
    */

    'google-timetable-id' => '76ambpj6tq40mlht0ok7ibonori7dliv@import.calendar.google.com',

    /*
    |--------------------------------------------------------------------------
    | SmartXp Timetable Calendar
    |--------------------------------------------------------------------------
    |
    | The Google calendar ID for the imported timetable.
    |
    */

    'smartxp-google-timetable-id' => 'sk5jps5kgrmvq5gp6oc20qfrmsvdfin7@import.calendar.google.com',

    /*
    |--------------------------------------------------------------------------
    | Internal Name
    |--------------------------------------------------------------------------
    |
    | The name that is shown in e-mails as the Officer Internal Affairs.
    |
    */

    'internal' => 'Laura Kester',

    /*
    |--------------------------------------------------------------------------
    | Treasurer Name
    |--------------------------------------------------------------------------
    |
    | The name that is shown in e-mails as the Treasurer.
    |
    */

    'treasurer' => 'Jur van Geel',

    /*
    |--------------------------------------------------------------------------
    | Proto Incassant ID
    |--------------------------------------------------------------------------
    |
    | Proto's Incassant ID.
    |
    */

    'incassant-id' => 'NL65ZZZ525625650000',

    /*
    |--------------------------------------------------------------------------
    | Secretary Name
    |--------------------------------------------------------------------------
    |
    | The name that is shown in e-mails as the Secretary.
    |
    */

    'secretary' => 'Dennis Vinke',

    /*
    |--------------------------------------------------------------------------
    | Main Study
    |--------------------------------------------------------------------------
    |
    | The ID of the study that is prominently featured on the courses page.
    |
    */

    'mainstudy' => 1,

    /*
    |--------------------------------------------------------------------------
    | Max tickets per transaction
    |--------------------------------------------------------------------------
    |
    | The maximum amount of tickets per ticket per transaction someone can buy.
    |
    */

    'maxtickets' => 10,

    /*
    |--------------------------------------------------------------------------
    | Domain Configuration
    |--------------------------------------------------------------------------
    |
    | Domains that are linked to various routes.
    |
    */

    'domains' => [
        'protube' => [
            'protube.nl',
            'www.protube.nl'
        ],
        'omnomcom' => [
            'omnomcom.nl',
            'www.omnomcom.nl'
        ],
        'smartxp' => [
            'smartxp.nl',
            'www.smartxp.nl',
            'caniworkinthesmartxp.nl',
            'www.caniworkinthesmartxp.nl'
        ],
        'developers' => [
            'haveyoutriedturningitoffandonagain.nl',
            'www.haveyoutriedturningitoffandonagain.nl'
        ]
    ]

];
