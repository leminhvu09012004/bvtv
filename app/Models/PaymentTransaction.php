<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'transaction_reference',
        'method',
        'amount',
        'status',
        'provider_response_payload',
        'idempotency_key',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'provider_response_payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
