<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesticide_id',
        'sku',
        'barcode',
        'specification',
        'unit',
        'cost_price',
        'selling_price',
        'promotional_price',
        'weight_grams',
        'image',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'integer',
        'selling_price' => 'integer',
        'promotional_price' => 'integer',
        'weight_grams' => 'integer',
    ];

    public function pesticide(): BelongsTo
    {
        return $this->belongsTo(Pesticide::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'variant_id');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'variant_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }

    public function getEffectivePriceAttribute(): int
    {
        return $this->promotional_price ?? $this->selling_price;
    }

    public function getVariantNameAttribute(): string
    {
        return $this->specification ?? 'Tiêu chuẩn';
    }

    public function getPriceAttribute(): int
    {
        return $this->effective_price;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->effective_price, 0, ',', '.') . ' ₫';
    }
}
