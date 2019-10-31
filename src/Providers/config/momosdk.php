<?php
return [
    //accepted values sandbox|live
    'base_uri' => env('MOMO_BASE', 'https://sandbox.momodeveloper.mtn.com/'),
    'api_version' => env('MOMO_API_VERSION', 'v1_0'),
    'environment' => env('MOMO_ENVIRONMENT', 'sandbox'),
    'prefix' => env('MOMO_PREFIX', 'momo_sdk_'),
    'tags_disabled' => env('DISABLE_TAGS', false),
    //eg example.com
    'hostname' => env('MOMO_HOST'),

    'collection' => [
        'primarykey' => env('REQUEST_TO_PAY_PRIMARY'),
        'secondarykey' => env('REQUEST_TO_PAY_SECONDARY'),
        'api_key' => env('REQUEST_TO_PAY_API_KEY'),
        'apiuser' => env('REQUEST_TO_PAY_API_USER'),
        'callback_url' => env('REQUEST_PAY_CALLBACK_URL'),
    ],

    'remittance' => [
        'primarykey' => env('REMITTANCES_PRIMARY'),
        'secondarykey' => env('REMITTANCES_SECONDARY'),
        'apikey' => env('REMITTANCES_API_KEY'),
        'apiuser' => env('REMITTANCES_API_USER'),
        'callback_url' => env('REMITTANCES_CALLBACK_URL'),
    ],

    'disbursement' => [
        'primarykey' => env('DISBURSEMENTS_PRIMARY'),
        'secondarykey' => env('DISBURSEMENTS_SECONDARY'),
        'api_key' => env('DISBURSEMENTS_API_KEY'),
        'apiuser' => env('DISBURSEMENTS_API_USER'),
        'callback_url' => env('DISBURSEMENTS_CALLBACK_URL'),
    ],
];
