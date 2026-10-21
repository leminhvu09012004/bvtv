<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_profile_id',
        'recipient_name',
        'recipient_phone',
        'province_id',
        'province_name',
        'district_id',
        'district_name',
        'ward_id',
        'ward_name',
        'street_address',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customerProfile(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class);
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->street_address}, {$this->ward_name}, {$this->district_name}, {$this->province_name}";
    }
}
