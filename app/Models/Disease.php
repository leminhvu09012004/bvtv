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
        'crop_name',
        'pathogen_type',
        'folder_code',
        'folder_group',
        'folder_name',
        'folder_number',
        'caunho',
        'image',
        'images',
        'symptoms',
        'symptoms_detail',
        'prevention',
        'treatment',
        'chemical_groups',
        'treatment_plans',
        'notes',
    ];

    protected $casts = [
        'images' => 'array',
        'symptoms_detail' => 'array',
        'treatment_plans' => 'array',
        'folder_number' => 'integer',
    ];

    protected $appends = ['image_url', 'images_urls', 'hydrated_treatment_plans', 'pathogen_label', 'crop_names', 'folder_group_label'];

    /**
     * Danh sách tên các cây trồng bị ảnh hưởng.
     */
    public function getCropNamesAttribute(): array
    {
        if ($this->relationLoaded('crops') && $this->crops->isNotEmpty()) {
            return $this->crops->pluck('name')->toArray();
        }
        return $this->crop_name ? array_map('trim', explode(',', $this->crop_name)) : [];
    }

    public const PATHOGEN_TYPES = [
        'nam' => [
            'label' => 'Nấm bệnh',
            'emoji' => '🍄',
            'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
        ],
        'nam_benh' => [
            'label' => 'Nấm bệnh',
            'emoji' => '🍄',
            'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
        ],
        'virus' => [
            'label' => 'Virus hại',
            'emoji' => '🦠',
            'badge' => 'bg-purple-100 text-purple-800 border-purple-300',
        ],
        'tuyen_trung' => [
            'label' => 'Tuyến trùng',
            'emoji' => '🪱',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
        ],
        'vi_khuan' => [
            'label' => 'Vi khuẩn & Tảo',
            'emoji' => '🧪',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
        ],
        'sau_hai' => [
            'label' => 'Sâu & Côn trùng hại',
            'emoji' => '🐛',
            'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        ],
        'nhen' => [
            'label' => 'Nhện hại cây',
            'emoji' => '🕷️',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
        ],
        'chich_hut' => [
            'label' => 'Côn trùng chích hút',
            'emoji' => '🦟',
            'badge' => 'bg-sky-100 text-sky-800 border-sky-300',
        ],
    ];

    public function getPathogenLabelAttribute(): string
    {
        return self::PATHOGEN_TYPES[$this->pathogen_type]['label'] ?? 'Chưa phân loại';
    }

    public function getPathogenEmojiAttribute(): string
    {
        return self::PATHOGEN_TYPES[$this->pathogen_type]['emoji'] ?? '🌿';
    }

    public function getPathogenBadgeAttribute(): string
    {
        return self::PATHOGEN_TYPES[$this->pathogen_type]['badge'] ?? 'bg-slate-100 text-slate-800 border-slate-300';
    }

    public const FOLDER_GROUPS = [
        'nam_benh' => [
            'label' => 'Nấm & Bệnh hại (14)',
            'emoji' => '🍄',
            'badge' => 'bg-amber-100 text-amber-900 border-amber-300',
        ],
        'chich_hut' => [
            'label' => 'Côn trùng chích hút (6)',
            'emoji' => '🦟',
            'badge' => 'bg-sky-100 text-sky-900 border-sky-300',
        ],
        'sau_hai' => [
            'label' => 'Sâu hại cắn phá & Ruồi (5)',
            'emoji' => '🐛',
            'badge' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
        ],
        'nhen_tuyen_trung' => [
            'label' => 'Nhện & Tuyến trùng (2)',
            'emoji' => '🕷️',
            'badge' => 'bg-rose-100 text-rose-900 border-rose-300',
        ],
    ];

    public function getFolderGroupLabelAttribute(): string
    {
        return self::FOLDER_GROUPS[$this->folder_group]['label'] ?? 'Khác';
    }

    public function getFolderBadgeAttribute(): string
    {
        return self::FOLDER_GROUPS[$this->folder_group]['badge'] ?? 'bg-slate-100 text-slate-800 border-slate-300';
    }

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
     * Các loại cây trồng có thể bị bệnh này gây hại (Many-to-Many).
     */
    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'crop_disease')
            ->withPivot('notes_on_crop')
            ->withTimestamps();
    }

    /**
     * Các loại thuốc cần dùng để trị bệnh này (Many-to-Many).
     */
    public function pesticides(): BelongsToMany
    {
        return $this->belongsToMany(Pesticide::class, 'disease_pesticide');
    }

    /**
     * Trích xuất danh sách các hoạt chất khuyến cáo từ chuỗi chemical_groups.
     *
     * @return array<string>
     */
    public function extractActiveIngredients(): array
    {
        $raw = $this->chemical_groups ?? '';
        if (trim($raw) === '') {
            return [];
        }

        // Loại bỏ các mã phân loại kỹ thuật FRAC / IRAC trong hoặc ngoài ngoặc đơn
        $text = preg_replace('/\(?\b(FRAC|IRAC|Nhóm\s+FRAC|Nhóm\s+IRAC|Sinh\s+học)[^)]*\)?/iu', '', $raw);

        // Tách theo dấu phẩy, chấm phẩy, gạch chéo, dấu cộng, ngoặc đơn
        $parts = preg_split('/[,;\/\+\n\r\(\)]+/', $text);
        $ingredients = [];

        foreach ($parts as $part) {
            $cleaned = trim($part);
            // Loại bỏ các từ ngữ chung/tiền tố diễn giải
            $cleaned = preg_replace('/^(Chế phẩm sinh học|Chế phẩm|Nhóm|Vi sinh|Nấm bẫy|Thuốc trừ sâu chích hút:|Thuốc trừ sâu|Thuốc trừ nấm|Thuốc gốc|Chất kích kháng sinh học|kết hợp)\s*/iu', '', $cleaned);
            $cleaned = trim($cleaned, " \t\n\r\0\x0B.:-");

            if (mb_strlen($cleaned) >= 3 && !preg_match('/^(FRAC|IRAC|sp\.|đối kháng|hạn chế)/iu', $cleaned)) {
                $ingredients[] = $cleaned;
            }
        }

        return array_values(array_unique(array_filter($ingredients)));
    }

    /**
     * Tìm tất cả sản phẩm thuốc trong kho có cùng hoạt chất với bệnh này.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMatchingPesticides()
    {
        $ingredients = $this->extractActiveIngredients();
        if (empty($ingredients)) {
            return collect();
        }

        return Pesticide::with('category')->where(function ($query) use ($ingredients) {
            foreach ($ingredients as $ing) {
                $query->orWhere('active_ingredient', 'like', "%{$ing}%")
                      ->orWhere('name', 'like', "%{$ing}%");
            }
        })->get();
    }

    /**
     * Tự động quét và liên kết (sync) tất cả sản phẩm thuốc có cùng hoạt chất trong kho.
     *
     * @return int Số lượng thuốc đã được quét và liên kết
     */
    public function autoSyncPesticidesByChemicalGroups(): int
    {
        $matched = $this->getMatchingPesticides();
        if ($matched->isNotEmpty()) {
            $this->pesticides()->syncWithoutDetaching($matched->pluck('id')->toArray());
        }

        return $matched->count();
    }
}
