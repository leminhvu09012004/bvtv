<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_code',
        'full_name',
        'phone',
        'crop_type',
        'farm_area_hectares',
        'total_spent',
        'loyalty_points',
        'loyalty_tier',
        'notes',
    ];

    protected $casts = [
        'farm_area_hectares' => 'decimal:2',
        'total_spent' => 'integer',
        'loyalty_points' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function defaultAddress()
    {
        return $this->addresses()->where('is_default', true)->first();
    }
}
