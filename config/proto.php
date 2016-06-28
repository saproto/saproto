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

    'tfaroles' => ['admin', 'board']

];
