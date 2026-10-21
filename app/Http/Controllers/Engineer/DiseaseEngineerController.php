<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DiseaseEngineerController extends Controller
{
    /**
     * Danh sách các loại cây trồng hỗ trợ mặc định (Fallback).
     */
    public const CROPS = [
        'Sầu riêng' => [
            'name' => 'Sầu riêng',
            'slug' => 'sau-rieng',
            'emoji' => '🍈',
            'desc' => 'Vua cây ăn trái — Đốm lá, xì mủ Phytophthora, cháy lá chết đọt',
        ],
        'Chanh dây' => [
            'name' => 'Chanh dây',
            'slug' => 'chanh-day',
            'emoji' => '🍋',
            'desc' => 'Đặc sản xuất khẩu Đắk Lắk & Tây Nguyên — Nhạy cảm nấm Oomycetes, Virus khảm',
        ],
        'Cà phê' => [
            'name' => 'Cà phê',
            'slug' => 'ca-phe',
            'emoji' => '☕',
            'desc' => 'Cây công nghiệp chủ lực — Rỉ sắt, nấm hồng, lở cổ rễ',
        ],
        'Hồ tiêu' => [
            'name' => 'Hồ tiêu',
            'slug' => 'ho-tieu',
            'emoji' => '🌿',
            'desc' => 'Hạt ngọc đen — Chết nhanh Phytophthora, chết chậm tuyến trùng',
        ],
        'Cây có múi' => [
            'name' => 'Cây có múi',
            'slug' => 'cay-co-mui',
            'emoji' => '🍊',
            'desc' => 'Cam, Quýt, Bưởi — Ghẻ loét vi khuẩn, vàng lá gân xanh Greening',
        ],
    ];

    /**
     * Giao diện Không gian Bệnh hại & Phác đồ Kỹ sư.
     */
    public function index(Request $request): View
    {
        $selectedCrop = $request->query('crop', 'all');
        $selectedPathogen = $request->query('pathogen');
        $searchQuery = trim($request->query('q', ''));

        // Tải danh sách bệnh và quan hệ (nếu có lọc tác nhân qua query URL thì lọc theo tác nhân)
        $diseasesQuery = Disease::with(['pesticides.category', 'crops'])->orderBy('name');
        if ($selectedPathogen) {
            $diseasesQuery->where('pathogen_type', $selectedPathogen);
        }
        $diseases = $diseasesQuery->get();

        // Thống kê đếm theo tác nhân của cây hiện tại
        $cropQuery = Disease::query();
        if ($selectedCrop && $selectedCrop !== 'all') {
            $cropQuery->where(function ($q) use ($selectedCrop) {
                $q->whereHas('crops', function ($cq) use ($selectedCrop) {
                    $cq->where('name', $selectedCrop)
                       ->orWhere('slug', $selectedCrop);
                })->orWhere('crop_name', 'like', "%{$selectedCrop}%");
            });
        }
        $allCropDiseases = $cropQuery->get();

        $stats = [
            'total' => $allCropDiseases->count(),
            'nam' => $allCropDiseases->where('pathogen_type', 'nam')->count(),
            'virus' => $allCropDiseases->where('pathogen_type', 'virus')->count(),
            'tuyen_trung' => $allCropDiseases->where('pathogen_type', 'tuyen_trung')->count(),
            'vi_khuan' => $allCropDiseases->where('pathogen_type', 'vi_khuan')->count(),
            'sau_hai' => $allCropDiseases->where('pathogen_type', 'sau_hai')->count(),
        ];

        // Lấy danh sách cây trồng từ DB
        $allCrops = Crop::orderBy('sort_order')->get();
        if ($allCrops->isEmpty()) {
            $cropsList = self::CROPS;
        } else {
            $cropsList = [];
            foreach ($allCrops as $c) {
                $cropsList[$c->name] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'emoji' => $c->emoji,
                    'desc' => $c->description,
                ];
            }
        }

        // Đếm số lượng bệnh thực tế của từng cây trồng
        $cropCounts = [];
        foreach ($cropsList as $cKey => $cInfo) {
            $cropCounts[$cKey] = Disease::where(function ($q) use ($cKey) {
                $q->whereHas('crops', function ($cq) use ($cKey) {
                    $cq->where('name', $cKey)
                       ->orWhere('slug', $cKey);
                })->orWhere('crop_name', 'like', "%{$cKey}%");
            })->count();
        }
        $totalAllDiseasesCount = Disease::count();

        // Đếm số lượng bệnh theo nhóm phân loại của cây trồng hiện tại
        $groupCounts = [
            'all' => $diseases->count(),
            'nam_benh' => $diseases->where('folder_group', 'nam_benh')->count(),
            'chich_hut' => $diseases->where('folder_group', 'chich_hut')->count(),
            'sau_hai' => $diseases->where('folder_group', 'sau_hai')->count(),
            'nhen_tuyen_trung' => $diseases->where('folder_group', 'nhen_tuyen_trung')->count(),
            'virus' => $diseases->where('pathogen_type', 'virus')->count(),
            'vi_khuan' => $diseases->where('pathogen_type', 'vi_khuan')->count(),
        ];

        // Lấy danh sách thuốc trong kho để gắn phác đồ điều trị
        $warehousePesticides = Pesticide::with('category')->orderBy('name')->get(['id', 'name', 'active_ingredient', 'category_id', 'form_type', 'water_volume', 'image']);

        return view('engineer.benh.index', [
            'diseases' => $diseases,
            'crops' => $cropsList,
            'allCrops' => $allCrops,
            'selectedCrop' => $selectedCrop,
            'selectedPathogen' => $selectedPathogen,
            'searchQuery' => $searchQuery,
            'stats' => $stats,
            'cropCounts' => $cropCounts,
            'totalAllDiseasesCount' => $totalAllDiseasesCount,
            'groupCounts' => $groupCounts,
            'warehousePesticides' => $warehousePesticides,
        ]);
    }

    /**
     * Giao diện Toàn Màn Hình Xem Chi Tiết Bệnh & Phác Đồ (Full Page View).
     */
    public function chiTiet(Disease $disease): View
    {
        $disease->load(['pesticides.category', 'crops']);
        $allCrops = Crop::orderBy('sort_order')->get();
        $cropsList = self::CROPS;
        if ($allCrops->isNotEmpty()) {
            $cropsList = [];
            foreach ($allCrops as $c) {
                $cropsList[$c->name] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'emoji' => $c->emoji,
                    'desc' => $c->description,
                ];
            }
        }

        $warehousePesticides = Pesticide::with('category')->orderBy('name')->get(['id', 'name', 'active_ingredient', 'category_id', 'form_type', 'water_volume', 'image']);

        return view('engineer.benh.chi-tiet', [
            'disease' => $disease,
            'crops' => $cropsList,
            'allCrops' => $allCrops,
            'warehousePesticides' => $warehousePesticides,
        ]);
    }

    /**
     * Giao diện Toàn Trang Chỉnh Sửa Bệnh Cây Trồng (Dedicated Edit Page).
     */
    public function edit(Disease $disease): View
    {
        $disease->load(['pesticides.category', 'crops']);
        $allCrops = Crop::orderBy('sort_order')->get();
        $cropsList = self::CROPS;
        if ($allCrops->isNotEmpty()) {
            $cropsList = [];
            foreach ($allCrops as $c) {
                $cropsList[$c->name] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'emoji' => $c->emoji,
                    'desc' => $c->description,
                ];
            }
        }

        $warehousePesticides = Pesticide::with('category')->orderBy('name')->get(['id', 'name', 'active_ingredient', 'category_id', 'form_type', 'water_volume', 'image']);

        return view('engineer.benh.edit', [
            'disease' => $disease,
            'crops' => $cropsList,
            'allCrops' => $allCrops,
            'warehousePesticides' => $warehousePesticides,
        ]);
    }

    /**
     * AJAX lấy chi tiết 1 bệnh.
     */
    public function ajaxShow(Disease $disease): JsonResponse
    {
        $disease->load(['pesticides.category', 'crops']);

        return response()->json([
            'success' => true,
            'disease' => [
                'id' => $disease->id,
                'name' => $disease->name,
                'crop_name' => $disease->crop_name ?? '',
                'crop_ids' => $disease->crops->pluck('id')->toArray(),
                'crop_names' => $disease->crops->pluck('name')->toArray(),
                'pathogen_type' => $disease->pathogen_type ?? 'nam',
                'pathogen_label' => $disease->pathogen_label,
                'pathogen_emoji' => $disease->pathogen_emoji,
                'pathogen_badge' => $disease->pathogen_badge,
                'caunho' => $disease->caunho,
                'symptoms' => $disease->symptoms,
                'symptoms_detail' => $disease->symptoms_detail ?? [
                    'la' => '',
                    'canh_than' => '',
                    'goc_re' => '',
                    'qua' => '',
                ],
                'prevention' => $disease->prevention,
                'treatment' => $disease->treatment,
                'chemical_groups' => $disease->chemical_groups,
                'notes' => $disease->notes,
                'images' => $disease->images_urls,
                'image_url' => $disease->image_url,
                'pesticide_ids' => $disease->pesticides->pluck('id')->toArray(),
                'pesticides' => $disease->pesticides->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'active_ingredient' => $p->active_ingredient,
                    'category' => $p->category?->name ?? 'Thuốc BVTV',
                    'form_type' => $p->form_type ?? '',
                    'water_volume' => $p->water_volume ?? '',
                    'image_url' => $p->image_url,
                ]),
            ],
        ]);
    }

    /**
     * AJAX Thêm mới bệnh cây trồng.
     */
    public function ajaxStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:diseases,name'],
            'crop_name' => ['nullable', 'string', 'max:255'],
            'crop_ids' => ['nullable', 'array'],
            'crop_ids.*' => ['integer', 'exists:crops,id'],
            'pathogen_type' => ['required', 'in:nam,virus,tuyen_trung,vi_khuan,sau_hai'],
            'caunho' => ['nullable', 'string', 'max:1000'],
            'symptoms' => ['nullable', 'string', 'max:5000'],
            'symptoms_la' => ['nullable', 'string', 'max:2000'],
            'symptoms_canh_than' => ['nullable', 'string', 'max:2000'],
            'symptoms_goc_re' => ['nullable', 'string', 'max:2000'],
            'symptoms_qua' => ['nullable', 'string', 'max:2000'],
            'prevention' => ['nullable', 'string', 'max:5000'],
            'treatment' => ['nullable', 'string', 'max:5000'],
            'chemical_groups' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'pesticide_ids' => ['nullable', 'array'],
            'pesticide_ids.*' => ['integer', 'exists:pesticides,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:5120'], // tối đa 5MB mỗi ảnh
        ], [
            'name.required' => 'Vui lòng nhập tên bệnh.',
            'name.unique' => 'Bệnh này đã có trong hệ thống.',
            'pathogen_type.required' => 'Vui lòng chọn tác nhân gây bệnh.',
            'images.*.image' => 'File tải lên phải là hình ảnh (jpg, png, webp).',
            'images.*.max' => 'Mỗi ảnh không được vượt quá 5MB.',
        ]);

        $imagesList = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $imagesList[] = $file->store('diseases', 'public');
                }
            }
        }

        $symptomsDetail = [
            'la' => $validated['symptoms_la'] ?? '',
            'canh_than' => $validated['symptoms_canh_than'] ?? '',
            'goc_re' => $validated['symptoms_goc_re'] ?? '',
            'qua' => $validated['symptoms_qua'] ?? '',
        ];

        // Xác định danh sách cây trồng
        $cropIds = $validated['crop_ids'] ?? [];
        if (empty($cropIds) && !empty($validated['crop_name'])) {
            $matchedCrop = Crop::where('name', $validated['crop_name'])->first();
            if ($matchedCrop) {
                $cropIds[] = $matchedCrop->id;
            }
        }
        $cropNamesStr = !empty($cropIds) 
            ? Crop::whereIn('id', $cropIds)->pluck('name')->implode(', ')
            : ($validated['crop_name'] ?? '');

        $disease = Disease::create([
            'name' => $validated['name'],
            'crop_name' => $cropNamesStr,
            'pathogen_type' => $validated['pathogen_type'],
            'caunho' => $validated['caunho'] ?? null,
            'symptoms' => $validated['symptoms'] ?? null,
            'symptoms_detail' => $symptomsDetail,
            'prevention' => $validated['prevention'] ?? null,
            'treatment' => $validated['treatment'] ?? null,
            'chemical_groups' => $validated['chemical_groups'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'image' => $imagesList[0] ?? null,
            'images' => !empty($imagesList) ? $imagesList : null,
        ]);

        if (!empty($cropIds)) {
            $disease->crops()->sync($cropIds);
        }

        if (!empty($validated['pesticide_ids'])) {
            $disease->pesticides()->sync($validated['pesticide_ids']);
        } else {
            $disease->autoSyncPesticidesByChemicalGroups();
        }

        $disease->load(['pesticides.category', 'crops']);

        return response()->json([
            'success' => true,
            'message' => "Đã thêm bệnh \"{$disease->name}\" thành công.",
            'disease' => $disease,
        ], 201);
    }

    /**
     * AJAX Cập nhật bệnh cây trồng.
     */
    public function ajaxUpdate(Request $request, Disease $disease): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:diseases,name,' . $disease->id],
            'crop_name' => ['nullable', 'string', 'max:255'],
            'crop_ids' => ['nullable', 'array'],
            'crop_ids.*' => ['integer', 'exists:crops,id'],
            'pathogen_type' => ['required', 'in:nam,virus,tuyen_trung,vi_khuan,sau_hai'],
            'caunho' => ['nullable', 'string', 'max:1000'],
            'symptoms' => ['nullable', 'string', 'max:5000'],
            'symptoms_la' => ['nullable', 'string', 'max:2000'],
            'symptoms_canh_than' => ['nullable', 'string', 'max:2000'],
            'symptoms_goc_re' => ['nullable', 'string', 'max:2000'],
            'symptoms_qua' => ['nullable', 'string', 'max:2000'],
            'prevention' => ['nullable', 'string', 'max:5000'],
            'treatment' => ['nullable', 'string', 'max:5000'],
            'chemical_groups' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'pesticide_ids' => ['nullable', 'array'],
            'pesticide_ids.*' => ['integer', 'exists:pesticides,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:5120'],
        ], [
            'name.required' => 'Vui lòng nhập tên bệnh.',
            'name.unique' => 'Tên bệnh này đã trùng với bệnh khác.',
            'images.*.image' => 'File tải lên phải là hình ảnh (jpg, png, webp).',
            'images.*.max' => 'Mỗi ảnh không được vượt quá 5MB.',
        ]);

        $currentImages = is_array($disease->images) ? $disease->images : [];
        if ($disease->image && !in_array($disease->image, $currentImages)) {
            $currentImages[] = $disease->image;
        }

        // Xử lý danh sách ảnh bị xóa (nếu có)
        $deletedImages = $request->input('deleted_images', []);
        if (is_string($deletedImages)) {
            $deletedImages = json_decode($deletedImages, true) ?? [];
        }
        if (!empty($deletedImages) && is_array($deletedImages)) {
            $currentImages = array_filter($currentImages, function ($img) use ($deletedImages) {
                $fullUrl = asset('storage/' . $img);
                $isDeleted = in_array($img, $deletedImages) || in_array($fullUrl, $deletedImages);
                if ($isDeleted && Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
                return !$isDeleted;
            });
        }

        // Tải thêm ảnh mới nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $currentImages[] = $file->store('diseases', 'public');
                }
            }
        }

        // Thêm ảnh từ URL trực tiếp nếu có
        $newUrls = $request->input('new_image_urls', []);
        if (is_string($newUrls)) {
            $newUrls = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $newUrls)));
        }
        if (!empty($newUrls) && is_array($newUrls)) {
            foreach ($newUrls as $url) {
                if ($url && (str_starts_with($url, 'http://') || str_starts_with($url, 'https://'))) {
                    $currentImages[] = $url;
                }
            }
        }

        $symptomsDetail = [
            'la' => $validated['symptoms_la'] ?? ($disease->symptoms_detail['la'] ?? ''),
            'canh_than' => $validated['symptoms_canh_than'] ?? ($disease->symptoms_detail['canh_than'] ?? ''),
            'goc_re' => $validated['symptoms_goc_re'] ?? ($disease->symptoms_detail['goc_re'] ?? ''),
            'qua' => $validated['symptoms_qua'] ?? ($disease->symptoms_detail['qua'] ?? ''),
        ];

        // Xử lý crops
        $cropIds = $validated['crop_ids'] ?? null;
        if ($cropIds !== null) {
            $disease->crops()->sync($cropIds);
            if (!empty($cropIds)) {
                $disease->crop_name = Crop::whereIn('id', $cropIds)->pluck('name')->implode(', ');
            }
        } elseif (!empty($validated['crop_name'])) {
            $matchedCrop = Crop::where('name', $validated['crop_name'])->first();
            if ($matchedCrop) {
                $disease->crops()->sync([$matchedCrop->id]);
            }
            $disease->crop_name = $validated['crop_name'];
        }

        $disease->update([
            'name' => $validated['name'],
            'crop_name' => $disease->crop_name,
            'pathogen_type' => $validated['pathogen_type'],
            'caunho' => $validated['caunho'] ?? null,
            'symptoms' => $validated['symptoms'] ?? null,
            'symptoms_detail' => $symptomsDetail,
            'prevention' => $validated['prevention'] ?? null,
            'treatment' => $validated['treatment'] ?? null,
            'chemical_groups' => $validated['chemical_groups'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'image' => $currentImages[0] ?? null,
            'images' => !empty($currentImages) ? array_values(array_unique($currentImages)) : null,
        ]);

        if (isset($validated['pesticide_ids'])) {
            $disease->pesticides()->sync($validated['pesticide_ids']);
        }

        $disease->load(['pesticides.category', 'crops']);

        return response()->json([
            'success' => true,
            'message' => "Đã cập nhật bệnh \"{$disease->name}\" thành công.",
            'disease' => $disease,
        ]);
    }

    /**
     * AJAX Xóa một ảnh trong thư viện ảnh của bệnh.
     */
    public function ajaxDeleteImage(Request $request, Disease $disease): JsonResponse
    {
        $imageUrl = $request->input('image_url');
        $rawPath = $request->input('raw_path');
        $imageIndex = $request->has('image_index') ? (int) $request->input('image_index') : null;

        if (!$imageUrl && !$rawPath && $imageIndex === null) {
            return response()->json(['success' => false, 'message' => 'Thiếu thông tin nhận diện ảnh cần xóa.'], 400);
        }

        $images = is_array($disease->images) ? $disease->images : [];
        if (empty($images) && $disease->image) {
            $images = [$disease->image];
        }

        $newImages = [];
        $matched = false;

        foreach ($images as $idx => $img) {
            $cleanImg = trim($img);
            $fullUrl = asset('storage/' . $cleanImg);
            $isTarget = false;

            if ($imageIndex !== null && $idx === $imageIndex) {
                $isTarget = true;
            } elseif ($rawPath && ($rawPath === $cleanImg || str_ends_with($rawPath, $cleanImg) || str_ends_with($cleanImg, $rawPath))) {
                $isTarget = true;
            } elseif ($imageUrl) {
                $cleanUrl = urldecode($imageUrl);
                $cleanBase = basename($cleanImg);
                $targetBase = basename(parse_url($cleanUrl, PHP_URL_PATH) ?: $cleanUrl);

                if ($fullUrl === $imageUrl
                    || $cleanImg === $imageUrl
                    || str_ends_with($imageUrl, $cleanImg)
                    || str_ends_with($cleanUrl, $cleanImg)
                    || ($cleanBase !== '' && $cleanBase === $targetBase)) {
                    $isTarget = true;
                }
            }

            if ($isTarget && !$matched) {
                $matched = true;
                // Xóa file khỏi storage nếu tồn tại
                if (Storage::disk('public')->exists($cleanImg)) {
                    Storage::disk('public')->delete($cleanImg);
                }
            } else {
                $newImages[] = $img;
            }
        }

        $newImages = array_values($newImages);
        $disease->update([
            'images' => !empty($newImages) ? $newImages : null,
            'image' => $newImages[0] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh thành công.',
            'images' => $disease->images_urls,
            'remaining_count' => count($newImages),
        ]);
    }

    /**
     * AJAX Tải thêm ảnh mới tức thì vào thư viện của bệnh.
     */
    public function ajaxUploadImage(Request $request, Disease $disease): JsonResponse
    {
        $request->validate([
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:5120'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:2000'],
        ], [
            'images.*.image' => 'File phải là hình ảnh hợp lệ (jpg, png, webp).',
            'images.*.max' => 'Ảnh không được vượt quá 5MB.',
        ]);

        $images = is_array($disease->images) ? $disease->images : [];
        if (empty($images) && $disease->image) {
            $images = [$disease->image];
        }

        $uploaded = [];

        // Upload 1 ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $path = $file->store('diseases', 'public');
                $images[] = $path;
                $uploaded[] = asset('storage/' . $path);
            }
        }

        // Upload nhiều ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('diseases', 'public');
                    $images[] = $path;
                    $uploaded[] = asset('storage/' . $path);
                }
            }
        }

        // Thêm qua link ảnh
        if ($url = $request->input('image_url')) {
            $url = trim($url);
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                $images[] = $url;
                $uploaded[] = $url;
            }
        }

        $images = array_values(array_unique($images));
        $disease->update([
            'images' => !empty($images) ? $images : null,
            'image' => $images[0] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã tải thêm ' . count($uploaded) . ' ảnh thành công.',
            'uploaded' => $uploaded,
            'images' => $disease->images_urls,
            'total_count' => count($images),
        ]);
    }

    /**
     * AJAX Đặt một ảnh làm ảnh chính đại diện cho bệnh.
     */
    public function ajaxSetPrimaryImage(Request $request, Disease $disease): JsonResponse
    {
        $imageIndex = $request->has('image_index') ? (int) $request->input('image_index') : null;
        $imageUrl = $request->input('image_url');

        $images = is_array($disease->images) ? $disease->images : [];
        if (empty($images) && $disease->image) {
            $images = [$disease->image];
        }

        $targetImg = null;
        if ($imageIndex !== null && isset($images[$imageIndex])) {
            $targetImg = $images[$imageIndex];
            unset($images[$imageIndex]);
        } elseif ($imageUrl) {
            foreach ($images as $idx => $img) {
                if ($img === $imageUrl || asset('storage/' . $img) === $imageUrl || str_ends_with($imageUrl, $img)) {
                    $targetImg = $img;
                    unset($images[$idx]);
                    break;
                }
            }
        }

        if ($targetImg) {
            array_unshift($images, $targetImg);
            $images = array_values($images);
            $disease->update([
                'images' => $images,
                'image' => $images[0] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã đặt làm ảnh chính thành công.',
            'images' => $disease->images_urls,
        ]);
    }

    /**
     * AJAX Xóa hoàn toàn một bệnh.
     */
    public function ajaxDestroy(Disease $disease): JsonResponse
    {
        $diseaseName = $disease->name;

        // Xóa ảnh
        if (!empty($disease->images) && is_array($disease->images)) {
            foreach ($disease->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $disease->pesticides()->detach();
        $disease->delete();

        return response()->json([
            'success' => true,
            'message' => "Đã xóa bệnh \"{$diseaseName}\" thành công.",
        ]);
    }

    /**
     * AJAX Tự động quét và liên kết thuốc theo hoạt chất cho bệnh.
     */
    public function ajaxAutoSyncThuoc(Disease $disease): JsonResponse
    {
        $count = $disease->autoSyncPesticidesByChemicalGroups();
        $disease->load(['pesticides.category']);

        return response()->json([
            'success' => true,
            'message' => "Đã quét và liên kết thành công {$count} sản phẩm thuốc trong kho có cùng hoạt chất.",
            'matched_count' => $count,
            'pesticides' => $disease->pesticides,
        ]);
    }

    /**
     * AJAX Cập nhật/Gán trực tiếp danh sách thuốc từ kho cho bệnh.
     */
    public function ajaxGanThuoc(Request $request, Disease $disease): JsonResponse
    {
        $validated = $request->validate([
            'pesticide_ids' => ['nullable', 'array'],
            'pesticide_ids.*' => ['integer', 'exists:pesticides,id'],
        ]);

        $ids = $validated['pesticide_ids'] ?? [];
        $disease->pesticides()->sync($ids);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật danh sách thuốc liên kết thành công!',
            'count' => count($ids),
        ]);
    }

    /**
     * AJAX Tìm danh sách ID thuốc theo chuỗi hoạt chất nhập vào.
     */
    public function ajaxTimThuocTheoHoatChat(Request $request): JsonResponse
    {
        $chemicalGroups = (string) $request->input('chemical_groups', '');
        $tempDisease = new Disease(['chemical_groups' => $chemicalGroups]);
        $matching = $tempDisease->getMatchingPesticides();

        return response()->json([
            'success' => true,
            'matched_count' => $matching->count(),
            'pesticide_ids' => $matching->pluck('id')->values()->all(),
            'pesticides' => $matching->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'active_ingredient' => $p->active_ingredient,
            ]),
        ]);
    }
}
