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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'bunny_stream' => [
        'api_key' => env('BUNNY_STREAM_API_KEY'),
        'library_id' => env('BUNNY_STREAM_LIBRARY_ID'),
        'hostname' => env('BUNNY_STREAM_HOSTNAME'), // e.g. vz-xxxxxx.b-cdn.net
        'token_key' => env('BUNNY_STREAM_TOKEN_KEY'), // For URL Token Authentication
    ],
    'zoom' => [
        'client_id' => env('ZOOM_CLIENT_ID'),
        'client_secret' => env('ZOOM_CLIENT_SECRET'),
        'account_id' => env('ZOOM_ACCOUNT_ID'),
    ],
    'fcm' => [
        'project_id' => env('FCM_PROJECT_ID', 'easyta3lim-b5750'),
        'credentials' => env('FCM_CREDENTIALS', storage_path('app/json/fcm.json')),
    ],
];
