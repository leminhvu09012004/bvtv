<?php

namespace App\Models;

use Database\Factories\PesticideFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pesticide extends Model
{
    /** @use HasFactory<PesticideFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'image',
        'variants',
        'active_ingredient',
        'concentration',
        'water_volume',
        'stains_fruit',
        'usage',
        'target',
        'crops',
        'form_type',
        'manufacturer',
        'registration_number',
        'isolation_period',
        'notes',
    ];

    protected $casts = [
        'stains_fruit' => 'boolean',
        'variants' => 'array',
        'price' => 'integer',
    ];

    /**
     * Trả về giá đã định dạng VNĐ, ví dụ: "90.000 ₫"
     */
    public function getFormattedPriceAttribute(): ?string
    {
        return null;
    }

    public const PURPOSES = [
        're' => [
            'id' => 're',
            'label' => 'Phát triển rễ',
            'short_label' => 'Rễ',
            'emoji' => '🌱',
            'bg_class' => 'bg-amber-50 border-amber-200 text-amber-800',
            'active_class' => 'bg-amber-600 text-white border-amber-600 shadow-xs',
            'badge_class' => 'bg-amber-50 text-amber-800 border-amber-200',
            'description' => 'Kích rễ, ra rễ cám, phục hồi rễ, hạ phèn, giải độc đất',
        ],
        'cay' => [
            'id' => 'cay',
            'label' => 'Phát triển cây',
            'short_label' => 'Đọt & Cây',
            'emoji' => '🌿',
            'bg_class' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'active_class' => 'bg-emerald-600 text-white border-emerald-600 shadow-xs',
            'badge_class' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'description' => 'Kéo đọt, mập đọt, bung chồi, xanh dày lá, phục hồi cây suy',
        ],
        'hoa' => [
            'id' => 'hoa',
            'label' => 'Ra hoa',
            'short_label' => 'Mầm & Hoa',
            'emoji' => '🌸',
            'bg_class' => 'bg-rose-50 border-rose-200 text-rose-800',
            'active_class' => 'bg-rose-600 text-white border-rose-600 shadow-xs',
            'badge_class' => 'bg-rose-50 text-rose-800 border-rose-200',
            'description' => 'Tạo mầm hoa, kích ra hoa đồng loạt, dưỡng hoa, chống rụng hoa',
        ],
        'trai' => [
            'id' => 'trai',
            'label' => 'Nuôi trái',
            'short_label' => 'Nuôi trái',
            'emoji' => '🍈',
            'bg_class' => 'bg-orange-50 border-orange-200 text-orange-800',
            'active_class' => 'bg-orange-600 text-white border-orange-600 shadow-xs',
            'badge_class' => 'bg-orange-50 text-orange-800 border-orange-200',
            'description' => 'Lớn trái mau, phì trái, nở gai sầu riêng, ngọt trái, chống rụng trái non',
        ],
        'nam' => [
            'id' => 'nam',
            'label' => 'Nấm bệnh',
            'short_label' => 'Nấm',
            'emoji' => '🍄',
            'bg_class' => 'bg-red-50 border-red-200 text-red-800',
            'active_class' => 'bg-red-600 text-white border-red-600 shadow-xs',
            'badge_class' => 'bg-red-50 text-red-800 border-red-200',
            'description' => 'Phytophthora, thán thư, rỉ sắt, nấm hồng, xì mủ, thối rễ, đốm lá',
        ],
        'rep' => [
            'id' => 'rep',
            'label' => 'Rệp & Rầy',
            'short_label' => 'Rệp / Rầy',
            'emoji' => '🦗',
            'bg_class' => 'bg-purple-50 border-purple-200 text-purple-800',
            'active_class' => 'bg-purple-600 text-white border-purple-600 shadow-xs',
            'badge_class' => 'bg-purple-50 text-purple-800 border-purple-200',
            'description' => 'Đặc trị rệp sáp, rầy xanh, rầy nâu, bọ trĩ, nhện đỏ chích hút',
        ],
        'sau' => [
            'id' => 'sau',
            'label' => 'Sâu hại',
            'short_label' => 'Trừ sâu',
            'emoji' => '🐛',
            'bg_class' => 'bg-indigo-50 border-indigo-200 text-indigo-800',
            'active_class' => 'bg-indigo-600 text-white border-indigo-600 shadow-xs',
            'badge_class' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
            'description' => 'Đặc trị sâu đục thân, sâu đục cành, sâu đục trái, sâu cuốn lá, sâu tơ',
        ],
        'khuan' => [
            'id' => 'khuan',
            'label' => 'Vi khuẩn',
            'short_label' => 'Vi khuẩn',
            'emoji' => '🦠',
            'bg_class' => 'bg-teal-50 border-teal-200 text-teal-800',
            'active_class' => 'bg-teal-600 text-white border-teal-600 shadow-xs',
            'badge_class' => 'bg-teal-50 text-teal-800 border-teal-200',
            'description' => 'Kháng sinh diệt khuẩn, cháy bìa lá, loét sẹo, thối nhũn vi khuẩn',
        ],
    ];

    protected $appends = ['image_url', 'purposes'];

    /**
     * Danh sách biến thể (không sử dụng - dự án chuyển sang sổ tay học thuốc không giá / không size).
     */
    public function getFormattedVariantsAttribute(): array
    {
        return [];
    }

    /**
     * Khoảng giá (không sử dụng).
     */
    public function getPriceRangeAttribute(): ?string
    {
        return null;
    }

    /**
     * Đường dẫn ảnh đầy đủ (từ storage hoặc URL trực tiếp).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Chuẩn hóa ghi chú: chuyển literal \n thành xuống dòng thực tế.
     */
    public function getNotesAttribute(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        $text = str_replace(['\r\n', '\r', '\n'], "\n", $value);
        return str_replace(["\r\n", "\r"], "\n", $text);
    }

    /**
     * Làm sạch ghi chú trước khi lưu vào DB.
     */
    public function setNotesAttribute(?string $value): void
    {
        if (is_string($value)) {
            $text = str_replace(['\r\n', '\r', '\n'], "\n", $value);
            $this->attributes['notes'] = str_replace(["\r\n", "\r"], "\n", $text);
        } else {
            $this->attributes['notes'] = $value;
        }
    }

    /**
     * Xác định mục đích / giai đoạn cây trồng của sản phẩm.
     * Trả về mảng các mã mục đích: ['re', 'cay', 'hoa', 'trai', 'nam', 'rep', 'sau', 'khuan']
     */
    public function getPurposesAttribute(): array
    {
        $purposes = [];

        $catId = $this->category_id;
        $name = mb_strtolower($this->name ?? '');
        $target = mb_strtolower($this->target ?? '');
        $usage = mb_strtolower($this->usage ?? '');
        $active = mb_strtolower($this->active_ingredient ?? '');
        $notes = mb_strtolower($this->notes ?? '');

        $infoText = $name . ' ' . $target . ' ' . $notes;

        // 1. PHÁT TRIỂN RỄ (re)
        $reKeywords = [
            'kích rễ',
            'ra rễ',
            'phát triển rễ',
            'bộ rễ',
            'bộ rễ khỏe',
            'phục hồi rễ',
            'rễ cám',
            'tạo rễ',
            'bung rễ',
            'hạ phèn',
            'humic',
            'roots',
            'suy rễ',
            'kích thích rễ',
            'kích ra rễ',
            'dưỡng rễ'
        ];
        $isRootFungicideOnly = ($catId == 30 || $catId == 33) && !str_contains($infoText, 'kích rễ') && !str_contains($infoText, 'phục hồi rễ') && !str_contains($infoText, 'ra rễ');
        if (!$isRootFungicideOnly) {
            foreach ($reKeywords as $kw) {
                if (str_contains($infoText, $kw)) {
                    $purposes[] = 're';
                    break;
                }
            }
        }

        // 2. PHÁT TRIỂN CÂY / ĐỌT (cay)
        $cayKeywords = [
            'kéo đọt',
            'mập đọt',
            'đọt mập',
            'bung đọt',
            'vọt đọt',
            'phát đọt',
            'đọt non',
            'nhú đọt',
            'phóng đọt',
            'bung chồi',
            'chồi non',
            'đâm chồi',
            'xanh lá',
            'dày lá',
            'mở lá',
            'nở ngọn',
            'bóng lá',
            'phát triển thân',
            'phát triển cành',
            'phát triển cây',
            'phục hồi cây',
            'cây suy',
            'phục hồi vườn',
            'sinh trưởng mạnh',
            'lớn nhanh',
            'tăng sinh khối',
            'đâm tược',
            'vươn chồi',
            'amino',
            'chặn đọt',
            'già lá'
        ];
        if (in_array($catId, [31, 34, 32])) {
            foreach ($cayKeywords as $kw) {
                if (str_contains($infoText, $kw) || str_contains($usage, $kw)) {
                    $purposes[] = 'cay';
                    break;
                }
            }
        }

        // 3. HOA (hoa)
        $hoaKeywords = [
            'mầm hoa',
            'tạo mầm',
            'kích hoa',
            'ra hoa',
            'nở hoa',
            'phân hóa mầm',
            'dưỡng hoa',
            'sáng bông',
            'mập bông',
            'cuống hoa',
            'rụng hoa',
            'rụng bông',
            'thụ phấn',
            'đậu hoa',
            'hoa cái',
            'chống rụng hoa',
            'chống rụng bông',
            'bung hoa',
            '10.60.10',
            '10-60-10',
            'ra bông đồng loạt'
        ];
        foreach ($hoaKeywords as $kw) {
            if (str_contains($infoText, $kw)) {
                $purposes[] = 'hoa';
                break;
            }
        }

        // 4. TRÁI (trai)
        $traiKeywords = [
            'trái',
            'quả',
            'lớn trái',
            'phì trái',
            'nuôi trái',
            'nở gai',
            'tròn hộc',
            'đậu trái',
            'rụng trái',
            'chống rụng trái non',
            'trái non',
            'ngọt trái',
            'bóng trái',
            'đẹp trái',
            'sữa trái',
            'sửa tướng',
            'méo trái',
            'nứt trái',
            'nặng ký',
            'chắc ruột',
            'lên cơm',
            'cơm vàng',
            'kali bo',
            'canxi bo',
            'canxi - bo'
        ];
        if (in_array($catId, [31, 34, 32]) || str_contains($name, 'bo') || str_contains($name, 'kali') || str_contains($name, 'canxi')) {
            foreach ($traiKeywords as $kw) {
                if (str_contains($infoText, $kw)) {
                    $purposes[] = 'trai';
                    break;
                }
            }
        }

        // 5. NẤM BỆNH (nam)
        if ($catId == 30) {
            $purposes[] = 'nam';
        } else {
            $namKeywords = [
                'thán thư',
                'rỉ sắt',
                'nấm hồng',
                'đạo ôn',
                'xì mủ',
                'thối rễ',
                'đốm lá',
                'khô vằn',
                'sương mai',
                'phytophthora',
                'rhizoctonia',
                'fusarium',
                'colletotrichum',
                'pythium',
                'lasiodiplodia',
                'nấm bệnh',
                'trừ nấm',
                'diệt nấm',
                'khô cành',
                'cháy lá do nấm'
            ];
            foreach ($namKeywords as $kw) {
                if (str_contains($infoText, $kw)) {
                    $purposes[] = 'nam';
                    break;
                }
            }
        }

        // 6. RỆP & RẦY (rep)
        $repKeywords = [
            'rệp',
            'rệp sáp',
            'rầy',
            'rầy xanh',
            'rầy nâu',
            'rầy phấn',
            'bọ trĩ',
            'nhện đỏ',
            'rầy nhảy',
            'rệp muội',
            'chích hút',
            'bọ xít'
        ];
        if ($catId == 29) {
            foreach ($repKeywords as $kw) {
                if (str_contains($target, $kw) || str_contains($name, $kw)) {
                    $purposes[] = 'rep';
                    break;
                }
            }
        } else {
            $repActionWords = ['trị rệp', 'trừ rệp', 'diệt rệp', 'trị rầy', 'trừ rầy', 'diệt rầy', 'trị bọ trĩ', 'trừ bọ trĩ', 'trị nhện đỏ', 'trừ nhện đỏ'];
            foreach ($repActionWords as $kw) {
                if (str_contains($target, $kw) || str_contains($name, $kw)) {
                    $purposes[] = 'rep';
                    break;
                }
            }
        }

        // 7. SÂU HẠI (sau)
        $sauKeywords = [
            'sâu đục thân',
            'sâu cuốn lá',
            'sâu ăn lá',
            'sâu tơ',
            'sâu vẽ bùa',
            'sâu khoang',
            'sâu xanh',
            'sâu đục trái',
            'sâu đục cành',
            'sâu đo',
            'sâu róm',
            'sâu hại',
            'sâu non'
        ];
        if ($catId == 29) {
            foreach ($sauKeywords as $kw) {
                if (str_contains($target, $kw) || str_contains($name, $kw)) {
                    $purposes[] = 'sau';
                    break;
                }
            }
            if (!in_array('sau', $purposes) && str_contains($target, 'sâu') && !str_contains($target, 'giải độc') && !str_contains($target, 'kháng sâu')) {
                $purposes[] = 'sau';
            }
        }

        // 8. VI KHUẨN (khuan)
        if ($catId == 33) {
            $purposes[] = 'khuan';
        } else {
            $khuanKeywords = ['vi khuẩn', 'kháng sinh', 'cháy bìa lá', 'thối nhũn', 'bạc lá vi khuẩn', 'loét vi khuẩn'];
            foreach ($khuanKeywords as $kw) {
                if (str_contains($target, $kw) || str_contains($name, $kw) || str_contains($active, $kw)) {
                    $purposes[] = 'khuan';
                    break;
                }
            }
        }

        return array_values(array_unique($purposes));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Các bệnh có thể dùng thuốc này (Many-to-Many).
     */
    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'disease_pesticide');
    }

    /**
     * Scope for full-text search across key fields.
     *
     * @param  Builder<Pesticide>  $query
     */
    /**
     * Scope for full-text search across key fields or specific field.
     *
     * @param  Builder<Pesticide>  $query
     * @param  string|null  $scope  'name' | 'active_ingredient' | 'all' | null
     */
    public function scopeSearch(Builder $query, ?string $keyword, ?string $scope = null): Builder
    {
        if (!$keyword) {
            return $query;
        }

        $trimmed = trim($keyword);
        $words = array_values(array_filter(preg_split('/\s+/', $trimmed)));

        if (empty($words)) {
            return $query;
        }

        $uniqueWords = array_values(array_unique($words));

        // Biến thể cụm từ kết hợp các ký tự phân cách thông dụng (-, ., /)
        // Ví dụ: "15 15 15" -> "15-15-15", "15.15.15", "15/15/15"
        $phraseVariants = [
            $trimmed,
            implode('-', $words),
            implode('.', $words),
            implode('/', $words),
        ];
        $phraseVariants = array_values(array_unique(array_filter($phraseVariants)));

        $cleanId = preg_replace('/[^0-9]/', '', $trimmed);
        $isIdSearch = !empty($cleanId) && (
            is_numeric($trimmed) ||
            str_starts_with($trimmed, '#') ||
            preg_match('/^id[:\s]*\d+$/i', $trimmed)
        );

        return $query->where(function (Builder $q) use ($trimmed, $words, $uniqueWords, $phraseVariants, $cleanId, $isIdSearch, $scope) {
            // 1. Nếu là tìm kiếm theo ID (ví dụ: "54", "#54", "id: 54")
            if ($isIdSearch) {
                $q->orWhere('id', intval($cleanId));
            }

            if ($scope === 'name') {
                // TÌM CHÍNH XÁC THEO TÊN SẢN PHẨM:
                // a. Khớp cụm từ hoặc biến thể phân cách (15-15-15, 15.15.15,...)
                foreach ($phraseVariants as $pv) {
                    $q->orWhere('name', 'like', "%{$pv}%");
                }
                // b. Nếu có nhiều từ khác nhau (ví dụ "kẽm edta", "huỳnh lâm"), tất cả từ phải xuất hiện trong tên
                if (count($uniqueWords) > 1) {
                    $q->orWhere(function (Builder $allWords) use ($uniqueWords) {
                        foreach ($uniqueWords as $w) {
                            $allWords->where('name', 'like', "%{$w}%");
                        }
                    });
                } elseif (count($words) > 1 && count($uniqueWords) === 1) {
                    // Từ lặp như "15 15 15"
                    $w = $words[0];
                    $q->orWhere('name', 'like', "%{$w}-{$w}-{$w}%")
                        ->orWhere('name', 'like', "%{$w}.{$w}.{$w}%")
                        ->orWhere('name', 'like', "%{$w} {$w} {$w}%");
                }
            } elseif ($scope === 'active_ingredient') {
                // TÌM THEO HOẠT CHẤT:
                $q->orWhere('active_ingredient', 'like', "%{$trimmed}%");
                if (count($uniqueWords) > 1) {
                    $q->orWhere(function (Builder $allWords) use ($uniqueWords) {
                        foreach ($uniqueWords as $w) {
                            $allWords->where('active_ingredient', 'like', "%{$w}%");
                        }
                    });
                }
            } elseif ($scope === 'all') {
                // TÌM TẤT CẢ (Tên, hoạt chất, quy cách, công dụng, cây trồng):
                foreach ($phraseVariants as $pv) {
                    $q->orWhere('name', 'like', "%{$pv}%")
                        ->orWhere('active_ingredient', 'like', "%{$pv}%")
                        ->orWhere('usage', 'like', "%{$pv}%")
                        ->orWhere('target', 'like', "%{$pv}%")
                        ->orWhere('crops', 'like', "%{$pv}%");
                }
                if (count($uniqueWords) > 1) {
                    $q->orWhere(function (Builder $allWords) use ($uniqueWords) {
                        foreach ($uniqueWords as $w) {
                            $allWords->where(function (Builder $sub) use ($w) {
                                $sub->where('name', 'like', "%{$w}%")
                                    ->orWhere('active_ingredient', 'like', "%{$w}%")
                                    ->orWhere('usage', 'like', "%{$w}%")
                                    ->orWhere('crops', 'like', "%{$w}%");
                            });
                        }
                    });
                }
            } else {
                // MẶC ĐỊNH (Khi không truyền scope): Tìm trên Tên và Hoạt chất
                foreach ($phraseVariants as $pv) {
                    $q->orWhere('name', 'like', "%{$pv}%")
                        ->orWhere('active_ingredient', 'like', "%{$pv}%");
                }
                if (count($uniqueWords) > 1) {
                    $q->orWhere(function (Builder $allWords) use ($uniqueWords) {
                        foreach ($uniqueWords as $w) {
                            $allWords->where(function (Builder $sub) use ($w) {
                                $sub->where('name', 'like', "%{$w}%")
                                    ->orWhere('active_ingredient', 'like', "%{$w}%");
                            });
                        }
                    });
                } elseif (count($words) > 1 && count($uniqueWords) === 1) {
                    $w = $words[0];
                    $q->orWhere('name', 'like', "%{$w}-{$w}-{$w}%")
                        ->orWhere('name', 'like', "%{$w}.{$w}.{$w}%");
                }
            }
        });
    }
}
