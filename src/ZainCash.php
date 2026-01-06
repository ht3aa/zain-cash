<?php

namespace Ht3aa\ZainCash;

use Firebase\JWT\JWT;
use Ht3aa\ZainCash\Models\ZainCashTransaction;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ZainCash
{

    private string $base_url;

    private string $merchant_secret;

    private string $merchant_id;

    private string $msisdn;

    private string $payment_redirect_url;

    private string $webhook_url;

    private PendingRequest $client;



    public function __construct()
    {
        $this->base_url = config('zain-cash.is_production') ? 'https://api.zaincash.iq' : 'https://test.zaincash.iq';
        $this->payment_redirect_url = $this->base_url . '/transaction/pay?id=';
        $this->merchant_secret = config('zain-cash.merchant_secret');
        $this->merchant_id = config('zain-cash.merchant_id');
        $this->msisdn = config('zain-cash.msisdn');
        $this->webhook_url = config('zain-cash.webhook_url');


        $this->client = Http::baseUrl($this->base_url);
    }

    public function initiateTransaction(ZainCashTransaction $transaction): ZainCashTransaction
    {
        $data = [
            'msisdn' => $this->msisdn,
            'amount' => $transaction->amount,
            'serviceType' => $transaction->service_type,
            'orderId' => $transaction->order_id,
            'redirectUrl' => $this->webhook_url,
            'iat'  => time(),
            'exp'  => time() + 60 * 60 * 4
        ];

        $data['token'] = urlencode(JWT::encode($data, $this->merchant_secret, 'HS256'));
        $data['merchantId'] = $this->merchant_id;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $response = json_decode(file_get_contents($this->base_url . '/transaction/init', false, $context), true);


        if ($this->responseFailed($response)) {
            Log::error('Failed to initiate transaction', $response);
            throw new UnprocessableEntityHttpException('Failed to initiate transaction');
        }

        $transaction->iat = $data['iat'];
        $transaction->exp = $data['exp'];
        $transaction->token = $data['token'];
        $transaction->payment_redirect_url = $this->payment_redirect_url . $response['id'];
        $transaction->zain_cash_response = $response;
        $transaction->status = $response['status'];
        $transaction->transaction_id = $response['id'];

        return $transaction;
    }


    private function responseFailed($response): bool
    {
        return isset($response['err']);
    }
}
