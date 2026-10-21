<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_receipt_id',
        'variant_id',
        'quantity',
        'unit_cost',
        'line_total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'integer',
        'line_total' => 'integer',
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(PurchaseReceipt::class, 'purchase_receipt_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
