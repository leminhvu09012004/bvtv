<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'variant_id',
        'product_name',
        'variant_sku',
        'specification',
        'unit_cost_price',
        'unit_price',
        'quantity',
        'line_total',
    ];

    protected $casts = [
        'unit_cost_price' => 'integer',
        'unit_price' => 'integer',
        'quantity' => 'integer',
        'line_total' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->unit_price, 0, ',', '.') . ' ₫';
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->line_total, 0, ',', '.') . ' ₫';
    }
}
