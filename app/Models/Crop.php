<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'emoji',
        'description',
        'sort_order',
    ];

    /**
     * Danh sách các bệnh hại tấn công cây trồng này.
     */
    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'crop_disease')
            ->withPivot('notes_on_crop')
            ->withTimestamps();
    }
}
