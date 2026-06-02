<?php

return [
    'default_gateway' => env('PAYMENT_GATEWAY', 'fawaterak'),

    'fawaterak' => [
        'api_key' => env('FAWATERAK_API_KEY'),
        'sandbox' => env('FAWATERAK_SANDBOX', false),
        'redirections' => [
            'successUrl' => env('FAWATERAK_SUCCESS_URL'),
            'failUrl' => env('FAWATERAK_FAIL_URL'),
            'pendingUrl' => env('FAWATERAK_PENDING_URL'),
            'webhookUrl' => env('FAWATERAK_WEBHOOK_URL'),
        ],
    ],
];
