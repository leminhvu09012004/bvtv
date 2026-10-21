<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'channel',
        'warehouse_id',
        'cashier_id',
        'customer_profile_id',
        'shipping_recipient_name',
        'shipping_phone',
        'shipping_address_line',
        'shipping_ward',
        'shipping_district',
        'shipping_province',
        'subtotal',
        'discount_amount',
        'discount_reason',
        'shipping_fee',
        'total_amount',
        'payment_status',
        'fulfillment_status',
        'mixing_warning_acknowledged',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'discount_amount' => 'integer',
        'shipping_fee' => 'integer',
        'total_amount' => 'integer',
        'mixing_warning_acknowledged' => 'boolean',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function customerProfile(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', '.') . ' ₫';
    }
}
