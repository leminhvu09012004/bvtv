<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'quantity_on_hand',
        'quantity_reserved',
        'reorder_point',
        'bin_location',
        'last_counted_at',
    ];

    protected $casts = [
        'quantity_on_hand' => 'integer',
        'quantity_reserved' => 'integer',
        'quantity_available' => 'integer',
        'reorder_point' => 'integer',
        'last_counted_at' => 'datetime',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function isLowStock(): bool
    {
        return $this->quantity_available <= $this->reorder_point;
    }
}
