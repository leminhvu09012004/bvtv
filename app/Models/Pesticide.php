<?php

namespace App\Models;

use Database\Factories\PesticideFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesticide extends Model
{
    /** @use HasFactory<PesticideFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'active_ingredient',
        'concentration',
        'usage',
        'target',
        'crops',
        'form_type',
        'manufacturer',
        'registration_number',
        'isolation_period',
        'notes',
    ];

    protected $appends = ['image_url'];

    /**
     * Đường dẫn ảnh đầy đủ (từ storage hoặc URL trực tiếp).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope for full-text search across key fields.
     *
     * @param  Builder<Pesticide>  $query
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('active_ingredient', 'like', "%{$keyword}%")
                ->orWhere('usage', 'like', "%{$keyword}%")
                ->orWhere('crops', 'like', "%{$keyword}%")
                ->orWhere('target', 'like', "%{$keyword}%")
                ->orWhere('notes', 'like', "%{$keyword}%");
        });
    }
}
