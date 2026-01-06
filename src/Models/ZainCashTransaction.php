<?php

namespace Ht3aa\ZainCash\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ZainCashTransaction extends Model
{
    protected $fillable = [
        'amount',
        'service_type',
        'order_id',
        'order_type',
        'redirect_url',
        'token',
        'iat',
        'exp',
        'zain_cash_response',
        'status',
        'payment_redirect_url',
        'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'iat' => 'datetime',
        'exp' => 'datetime',
        'zain_cash_response' => 'array',
    ];

    public function order(): MorphTo
    {
        return $this->morphTo();
    }
}
