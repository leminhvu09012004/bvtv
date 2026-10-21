<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompatibilityRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_code',
        'scope',
        'entity_a_type',
        'entity_a_key',
        'entity_b_type',
        'entity_b_key',
        'status',
        'priority',
        'title',
        'reason',
        'conditions',
        'source_type',
        'source_reference',
        'confidence',
        'advice',
        'is_active',
    ];

    protected $casts = [
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];
}
