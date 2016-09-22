<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Root Committee
    |--------------------------------------------------------------------------
    |
    | The slug of the committee that is considered to have root access to the application.
    | This committee cannot be deleted, and members can only be added by members already part of the committee.
    | Members of this committee will always get the 'admin' role when successfully logging in.
    |
    */

    'rootcommittee' => 'haveyoutriedturningitoffandonagain',

    /*
    |--------------------------------------------------------------------------
    | Board Committee
    |--------------------------------------------------------------------------
    |
    | The slug of the committee that is considered to be the board committee of the application.
    | For example, this committee is used when generating the board page.
    | Members of this committee will always get the 'board' role when successfully logging in.
    |
    */

    'boardcommittee' => 'association-board',

    /*
    |--------------------------------------------------------------------------
    | OmNomCom Committee
    |--------------------------------------------------------------------------
    |
    | The slug of the committee that is considered to be the OmNomCom of the application.
    | Members of this committee will always get the 'omnomcom' role when successfully logging in.
    |
    */

    'omnomcom' => 'omnomcom',

    /*
    |--------------------------------------------------------------------------
    | PilsCie Committee
    |--------------------------------------------------------------------------
    |
    | The slug of the committee that is considered to be the PilsCie of the application.
    | Members of this committee will always get the 'pilscie' role when successfully logging in.
    |
    */

    'pilscie' => 'pilscie',

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

    'tfaroles' => ['admin', 'board'],

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
    | Public Timetable Calendar
    |--------------------------------------------------------------------------
    |
    | The Google calendar ID for the imported timetable.
    |
    */

    'google-timetable-id' => 'ldce9tj137p1q56i64bht9d53od36ist@import.calendar.google.com',

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

];
