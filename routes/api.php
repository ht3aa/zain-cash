<?php

use Ht3aa\ZainCash\Controllers\ZainCashWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('api/zain-cash/webhook', [ZainCashWebhookController::class, 'handle'])
    ->name('zain-cash.webhook');
