<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Custom Services untuk Microservices Architecture
    'member_service' => [
        'url' => env('MEMBER_SERVICE_URL', 'http://localhost:8001'),
        'token' => env('MEMBER_SERVICE_TOKEN', ''),
        'timeout' => env('MEMBER_SERVICE_TIMEOUT', 30),
        'retry_times' => env('MEMBER_SERVICE_RETRY_TIMES', 3),
        'retry_sleep' => env('MEMBER_SERVICE_RETRY_SLEEP', 100),
    ],

    'book_service' => [
        'url' => env('BOOK_SERVICE_URL', 'http://localhost:8002'),
        'token' => env('BOOK_SERVICE_TOKEN', ''),
        'timeout' => env('BOOK_SERVICE_TIMEOUT', 30),
        'retry_times' => env('BOOK_SERVICE_RETRY_TIMES', 3),
        'retry_sleep' => env('BOOK_SERVICE_RETRY_SLEEP', 100),
    ],

    'transaction_service' => [
        'url' => env('TRANSACTION_SERVICE_URL', 'http://localhost:8003'),
        'timeout' => env('TRANSACTION_SERVICE_TIMEOUT', 30),
    ],
];
