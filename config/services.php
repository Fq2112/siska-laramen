<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect' => env('FB_REDIRECT'),
    ],
    'google' => [
        'client_id' => env('G+_CLIENT_ID'),
        'client_secret' => env('G+_CLIENT_SECRET'),
        'redirect' => env('G+_REDIRECT'),
    ],
    'twitter' => [
        'client_id' => env('TW_CLIENT_ID'),
        'client_secret' => env('TW_CLIENT_SECRET'),
        'redirect' => env('TW_REDIRECT'),
    ],
    'github' => [
        'client_id' => env('GIT_CLIENT_ID'),
        'client_secret' => env('GIT_CLIENT_SECRET'),
        'redirect' => env('GIT_REDIRECT'),
    ],
    'linkedin' => [
        'client_id' => env('LinkedIn_CLIENT_ID'),
        'client_secret' => env('LinkedIn_CLIENT_SECRET'),
        'redirect' => env('LinkedIn_REDIRECT'),
    ],

];
