<?php

// config for Ht3aa/ZainCash
return [

    'is_production' => env('ZAIN_CASH_IS_PRODUCTION', false),
    'merchant_id' => env('ZAIN_CASH_MERCHANT_ID', '5ffacf6612b5777c6d44266f'),
    'merchant_secret' => env('ZAIN_CASH_MERCHANT_SECRET', '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS'),
    'msisdn' => env('ZAIN_CASH_MSISDN', '9647835077893'),
    'webhook_url' => env('ZAIN_CASH_WEBHOOK_URL', env('APP_URL').'/api/zain-cash/webhook'),
    'custom_webhook_url' => env('ZAIN_CASH_CUSTOM_WEBHOOK_URL', null),
];
