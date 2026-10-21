<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryCountItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_count_id',
        'variant_id',
        'system_quantity',
        'counted_quantity',
    ];

    protected $casts = [
        'system_quantity' => 'integer',
        'counted_quantity' => 'integer',
        'difference' => 'integer',
    ];

    public function inventoryCount(): BelongsTo
    {
        return $this->belongsTo(InventoryCount::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
