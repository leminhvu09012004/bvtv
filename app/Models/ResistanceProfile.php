<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResistanceProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_type',
        'code_value',
        'target_site_of_action',
        'risk_level',
        'cross_resistance_group',
        'rotation_advice',
    ];
}
