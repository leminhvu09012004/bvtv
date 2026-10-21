<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'count_code',
        'warehouse_id',
        'status',
        'reconciled_by',
        'reconciled_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reconciled_at' => 'datetime',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InventoryCountItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reconciler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciled_by');
    }
}
