<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_code',
        'warehouse_id',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StockIssueItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
