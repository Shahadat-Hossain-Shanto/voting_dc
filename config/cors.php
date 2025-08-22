<?php

return [ 

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths'                    => [ 
        'api/hire-sale',
        'api/payment',
        'api/hire-sale-return',
        'api/hire-sale-replace',
        'api/hire-sale-info',
        'api/hire-sale-device-info',
        'api/hire-sale-plaza/{plaza_id}/{start_date}/{end_date}',
        'api/inactive-devices/{plaza_id}',
    ],

    'allowed_methods'          => [ 
        'post',
        'get',
    ],

    'allowed_origins'          => [ 
        'https://eshop.bikroyik.com',
        'http://192.168.9.231',
        'http://localhost:8090',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers'          => [ '*' ],

    'exposed_headers'          => [],

    'max_age'                  => 0,

    'supports_credentials'     => false,

];
