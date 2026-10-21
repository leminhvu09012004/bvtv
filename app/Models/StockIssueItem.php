<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockIssueItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_issue_id',
        'variant_id',
        'quantity',
        'unit_cost',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'integer',
    ];

    public function issue(): BelongsTo
    {
        return $this->belongsTo(StockIssue::class, 'stock_issue_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
