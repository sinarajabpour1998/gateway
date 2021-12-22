<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following gateway to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => 'poolam',

    /*
    |--------------------------------------------------------------------------
    | Drivers Information
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers information to use in package.
    | You can change the information.
    |
    */
    'information' => [
        'parsian' => [
            'constructor' => [
                'pin' => env('PARSIAN_PIN', 'nan')
            ],
            'options' => [

            ]
        ],
        'pasargad' => [
            'constructor' => [
                'merchant_code' => env('PASARGAD_MERCHANT_CODE', 'nan'),
                'terminal_code' => env('PASARGAD_TERMINAL_CODE', 'nan'),
                'private_key'   => env('PASARGAD_PRIVATE_KEY', 'nan')
            ],
            'options' => [
                'verifySSL' => true
            ]
        ],
        'vandar' => [
            'constructor' => [
                'api_key' => env('VANDAR_API_KEY', 'nan'),
                'test' => false,
            ],
            'options' => [

            ]
        ],
        'poolam' => [
            'constructor' => [
                'api_url' => env('POOLAM_API_URL', 'nan'),
                'api_key' => env('POOLAM_API_KEY', 'nan'),
                'test' => false,
            ],
            'options' => [

            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name.
    |
    */
    'drivers' => [
        'parsian' => \Sinarajabpour1998\Gateway\Drivers\Parsian::class,
        'pasargad' => \Sinarajabpour1998\Gateway\Drivers\Pasargad::class,
        'vandar' => \Sinarajabpour1998\Gateway\Drivers\Vandar::class,
        'poolam' => \Sinarajabpour1998\Gateway\Drivers\Poolam::class
    ],

    /*
    |--------------------------------------------------------------------------
    | A Model that has relation with transaction, Order or Payment or ..
    |--------------------------------------------------------------------------
    |
    | Set the namespace of your model that has relation with Transaction.
    |
    */
    'model' => ''
];
