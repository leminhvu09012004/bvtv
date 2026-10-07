<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'images',
        'symptoms',
        'prevention',
        'treatment',
        'treatment_plans',
        'notes',
    ];

    protected $casts = [
        'images' => 'array',
        'treatment_plans' => 'array',
    ];

    protected $appends = ['image_url', 'images_urls', 'hydrated_treatment_plans'];

    /**
     * Đường dẫn ảnh đại diện chính (từ storage hoặc URL trực tiếp).
     */
    public function getImageUrlAttribute(): ?string
    {
        $firstImg = null;
        if (! empty($this->images) && is_array($this->images) && count($this->images) > 0) {
            $firstImg = $this->images[0];
        } elseif ($this->image) {
            $firstImg = $this->image;
        }

        if (! $firstImg) {
            return null;
        }

        if (str_starts_with($firstImg, 'http://') || str_starts_with($firstImg, 'https://')) {
            return $firstImg;
        }

        return asset('storage/' . $firstImg);
    }

    /**
     * Danh sách đầy đủ URL của tất cả các ảnh minh họa.
     *
     * @return array<string>
     */
    public function getImagesUrlsAttribute(): array
    {
        $list = [];

        if (! empty($this->images) && is_array($this->images)) {
            foreach ($this->images as $img) {
                if (! $img) continue;
                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                    $list[] = $img;
                } else {
                    $list[] = asset('storage/' . $img);
                }
            }
        } elseif ($this->image) {
            $list[] = $this->image_url;
        }

        return array_values(array_unique($list));
    }

    /**
     * Danh sách phác đồ phối hợp chi tiết kèm thông tin đối tượng thuốc.
     *
     * @return array
     */
    public function getHydratedTreatmentPlansAttribute(): array
    {
        if (empty($this->treatment_plans) || ! is_array($this->treatment_plans)) {
            return [];
        }

        // Lấy tất cả pesticide IDs trong treatment_plans
        $allIds = [];
        foreach ($this->treatment_plans as $plan) {
            foreach ($plan['groups'] ?? [] as $group) {
                if (! empty($group['primary_pesticide_id'])) {
                    $allIds[] = (int) $group['primary_pesticide_id'];
                }
                if (! empty($group['substitute_ids'])) {
                    foreach ((array) $group['substitute_ids'] as $sid) {
                        $allIds[] = (int) $sid;
                    }
                }
            }
        }
        $allIds = array_unique(array_filter($allIds));

        // Tải các pesticides kèm category
        $pesticidesMap = Pesticide::with('category')->whereIn('id', $allIds)->get()->keyBy('id');

        $hydrated = [];
        foreach ($this->treatment_plans as $plan) {
            $hydratedPlan = $plan;
            $hydratedGroups = [];
            foreach ($plan['groups'] ?? [] as $group) {
                $hGroup = $group;
                $hGroup['primary_pesticide'] = isset($group['primary_pesticide_id'])
                    ? ($pesticidesMap->get((int) $group['primary_pesticide_id']) ?? null)
                    : null;

                $substitutes = [];
                if (! empty($group['substitute_ids'])) {
                    foreach ((array) $group['substitute_ids'] as $subId) {
                        if ($p = $pesticidesMap->get((int) $subId)) {
                            $substitutes[] = $p;
                        }
                    }
                }
                $hGroup['substitutes'] = $substitutes;
                $hydratedGroups[] = $hGroup;
            }
            $hydratedPlan['groups'] = $hydratedGroups;
            $hydrated[] = $hydratedPlan;
        }

        return $hydrated;
    }

    /**
     * Các loại thuốc cần dùng để trị bệnh này (Many-to-Many).
     */
    public function pesticides(): BelongsToMany
    {
        return $this->belongsToMany(Pesticide::class, 'disease_pesticide');
    }
}
