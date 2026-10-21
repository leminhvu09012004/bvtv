<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    public $timestamps = false; // Bảng sổ cái bất biến chỉ có created_at

    protected $fillable = [
        'movement_code',
        'warehouse_id',
        'destination_warehouse_id',
        'variant_id',
        'type',
        'quantity_change',
        'balance_before',
        'balance_after',
        'unit_cost',
        'reference_type',
        'reference_id',
        'created_by',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'quantity_change' => 'integer',
        'balance_before' => 'integer',
        'balance_after' => 'integer',
        'unit_cost' => 'integer',
        'created_at' => 'datetime',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
