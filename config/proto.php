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

];
