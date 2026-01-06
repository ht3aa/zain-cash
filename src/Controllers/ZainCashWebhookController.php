<?php

namespace Ht3aa\ZainCash\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ht3aa\ZainCash\Models\ZainCashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ZainCashWebhookController
{
    public function handle(Request $request)
    {
        if (!$request->has('token')) {
            throw new UnprocessableEntityHttpException('Token is required');
        }

        $result = JWT::decode($request->token, new Key(config('zain-cash.merchant_secret'), 'HS256'));

        $zainCashTransaction = ZainCashTransaction::where('transaction_id', $result->id)->first();
        $zainCashTransaction->update([
            'status' => $result->status,
        ]);


        if (config('zain-cash.custom_webhook_url')) {
            Http::post(config('zain-cash.custom_webhook_url'), [
                'zain_cash_transaction_id' => $zainCashTransaction->id,
            ]);
        }
    }
}
