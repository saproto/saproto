<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OmNomCom Stores
    |--------------------------------------------------------------------------
    |
    | Defines the OmNomCom stores available, which products to show, and which
    | people or IP addresses are allowed to view them.
    |
    */

    'stores' => [
        'protopolis' => (object)[
            'name' => 'Protopolis',
            'categories' => [12, 1, 4, 5, 6, 22, 24, 7, 9, 11, 26],
            'addresses' => ['130.89.190.22', '2001:67c:2564:318:baae:edff:fe79:9aa3'],
            'roles' => ['board', 'omnomcom'],
            'cash_allowed' => false,
            'alcohol_time_constraint' => true,
        ],
        'tipcie' => (object)[
            'name' => 'TIPCie',
            'categories' => [15, 18, 25],
            'addresses' => [],
            'roles' => ['board', 'tipcie', 'drafters'],
            'cash_allowed' => true,
            'col_override' => 3,
            'alcohol_time_constraint' => false,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Alfred Account
    |--------------------------------------------------------------------------
    |
    | Defines the the financial account ID for Alfred's products.
    |
    */

    'alfred-account' => 43,

    /*
    |--------------------------------------------------------------------------
    | OmNomCom Account
    |--------------------------------------------------------------------------
    |
    | Defines the the financial account ID for OmNomCom products.
    |
    */

    'omnomcom-account' => 1,

    /*
    |--------------------------------------------------------------------------
    | TIPCie Account
    |--------------------------------------------------------------------------
    |
    | Defines the financial account used by the TIPCie
    |
    */

    'tipcie-account' => 4,

    /*
    |--------------------------------------------------------------------------
    | Mollie Settings
    |--------------------------------------------------------------------------
    |
    | Defines various configuration options for the Mollie integration.
    |
    */

    'mollie' => [
        'fixed_fee' => .3,
        'variable_fee' => .02,
        'fee_id' => 887
    ],

    /*
    |--------------------------------------------------------------------------
    | Membership Fee Settings
    |--------------------------------------------------------------------------
    |
    | Defines the products for membership fees.
    |
    */

    'fee' => [
        'regular' => 292,
        'reduced' => 293,
        'remitted' => 889,
    ],

    /*
    |--------------------------------------------------------------------------
    | ProTube Skip Product
    |--------------------------------------------------------------------------
    |
    | Defines the product for ProTube skip
    |
    */

    'protube-skip' => 40,

    /*
    |--------------------------------------------------------------------------
    | Times for buying alcoholic beverages
    |--------------------------------------------------------------------------
    |
    | Defines the times between which alcohol can be bought in Omnomcom.
    | The end-time needs to be a time on the next day.
    |
    */

    'alcohol-start' => "1530",
    'alcohol-end' => "0800",

];
