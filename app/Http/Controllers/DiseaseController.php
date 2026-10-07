<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DiseaseController extends Controller
{
    /**
     * Tra cứu các bài thuốc (Dành cho User / Chỉ xem).
     */
    public function index(): View
    {
        $diseases = Disease::with(['pesticides.category'])->orderBy('name')->get();

        return view('benh.tra-cuu', compact('diseases'));
    }

    /**
     * Quản lý bài thuốc & danh mục bệnh (Dành cho Admin - CRUD).
     */
    public function quanLy(): View
    {
        $diseases = Disease::with('pesticides')->orderBy('name')->get();
        $pesticides = Pesticide::with('category')->orderBy('name')->get();

        return view('benh.danh-sach', compact('diseases', 'pesticides'));
    }

    /**
     * Thêm bệnh mới qua AJAX — trả về JSON.
     */
    public function ajaxThem(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255', 'unique:diseases,name'],
            'symptoms'         => ['nullable', 'string', 'max:5000'],
            'prevention'       => ['nullable', 'string', 'max:5000'],
            'treatment'        => ['nullable', 'string', 'max:5000'],
            'notes'            => ['nullable', 'string', 'max:5000'],
            'image'            => ['nullable', 'image', 'max:5120'],
            'images'           => ['nullable', 'array'],
            'images.*'         => ['nullable', 'image', 'max:5120'],
            'treatment_plans'  => ['nullable'],
            'pesticide_ids'    => ['nullable', 'array'],
            'pesticide_ids.*'  => ['integer', 'exists:pesticides,id'],
        ], [
            'name.required'    => 'Vui lòng nhập tên bệnh.',
            'name.unique'      => 'Tên bệnh này đã tồn tại.',
            'images.*.image'   => 'Mỗi file phải là ảnh hợp lệ (jpg, png, webp...).',
            'images.*.max'     => 'Ảnh không được vượt quá 5MB.',
        ]);

        $imagesList = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $imagesList[] = $file->store('diseases', 'public');
                }
            }
        } elseif ($request->hasFile('image')) {
            $imagesList[] = $request->file('image')->store('diseases', 'public');
        }

        $treatmentPlans = $this->parseTreatmentPlans($request->input('treatment_plans'));

        $disease = Disease::create([
            'name'            => $validated['name'],
            'image'           => $imagesList[0] ?? null,
            'images'          => !empty($imagesList) ? $imagesList : null,
            'symptoms'        => $validated['symptoms'] ?? null,
            'prevention'      => $validated['prevention'] ?? null,
            'treatment'       => $validated['treatment'] ?? null,
            'treatment_plans' => $treatmentPlans,
            'notes'           => $validated['notes'] ?? null,
        ]);

        $pesticideIds = array_values(array_unique(array_merge(
            $validated['pesticide_ids'] ?? [],
            $this->extractPesticideIdsFromPlans($treatmentPlans)
        )));

        if (! empty($pesticideIds)) {
            $disease->pesticides()->sync($pesticideIds);
        }

        $disease->load('pesticides');

        return response()->json([
            'success'   => true,
            'thong_bao' => "Đã thêm bệnh \"{$disease->name}\" thành công.",
            'benh'      => $this->formatDisease($disease),
        ], 201);
    }

    /**
     * Cập nhật bệnh qua AJAX — trả về JSON.
     * Dùng POST thay PUT vì có upload file ảnh.
     */
    public function ajaxCapNhat(Request $request, Disease $disease): JsonResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255', "unique:diseases,name,{$disease->id}"],
            'symptoms'          => ['nullable', 'string', 'max:5000'],
            'prevention'        => ['nullable', 'string', 'max:5000'],
            'treatment'         => ['nullable', 'string', 'max:5000'],
            'treatment_plans'   => ['nullable'],
            'notes'             => ['nullable', 'string', 'max:5000'],
            'image'             => ['nullable', 'image', 'max:5120'],
            'images'            => ['nullable', 'array'],
            'images.*'          => ['nullable', 'image', 'max:5120'],
            'existing_images'   => ['nullable', 'array'],
            'existing_images.*' => ['nullable', 'string'],
            'pesticide_ids'     => ['nullable', 'array'],
            'pesticide_ids.*'   => ['integer', 'exists:pesticides,id'],
            'xoa_anh'           => ['nullable', 'string'],
        ], [
            'name.required'     => 'Vui lòng nhập tên bệnh.',
            'name.unique'       => 'Tên bệnh này đã tồn tại.',
            'images.*.image'    => 'Mỗi file phải là ảnh hợp lệ (jpg, png, webp...).',
            'images.*.max'      => 'Ảnh không được vượt quá 5MB.',
        ]);

        $currentStoredImages = $disease->images ?? [];
        if (empty($currentStoredImages) && $disease->image) {
            $currentStoredImages = [$disease->image];
        }

        // Lấy danh sách ảnh cũ người dùng chọn giữ lại
        $keptImages = [];
        if ($request->has('existing_images')) {
            $raw = $request->input('existing_images', []);
            $keptImages = is_array($raw) ? array_values(array_filter($raw)) : [];
        } elseif ($request->input('xoa_anh') === '1') {
            $keptImages = [];
        } else {
            $keptImages = $currentStoredImages;
        }

        // Xóa những ảnh cũ đã bị gỡ bỏ
        foreach ($currentStoredImages as $oldImg) {
            if (! in_array($oldImg, $keptImages, true)) {
                Storage::disk('public')->delete($oldImg);
            }
        }

        // Lưu các ảnh mới upload
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $newImages[] = $file->store('diseases', 'public');
                }
            }
        } elseif ($request->hasFile('image')) {
            $newImages[] = $request->file('image')->store('diseases', 'public');
        }

        $finalImages = array_values(array_merge($keptImages, $newImages));
        $treatmentPlans = $this->parseTreatmentPlans($request->input('treatment_plans'));

        $disease->update([
            'name'            => $validated['name'],
            'image'           => $finalImages[0] ?? null,
            'images'          => !empty($finalImages) ? $finalImages : null,
            'symptoms'        => $validated['symptoms'] ?? null,
            'prevention'      => $validated['prevention'] ?? null,
            'treatment'       => $validated['treatment'] ?? null,
            'treatment_plans' => $treatmentPlans,
            'notes'           => $validated['notes'] ?? null,
        ]);

        $pesticideIds = array_values(array_unique(array_merge(
            $validated['pesticide_ids'] ?? [],
            $this->extractPesticideIdsFromPlans($treatmentPlans)
        )));

        // Đồng bộ danh sách thuốc
        $disease->pesticides()->sync($pesticideIds);

        $disease->load('pesticides');

        return response()->json([
            'success'   => true,
            'thong_bao' => "Đã cập nhật bệnh \"{$disease->name}\" thành công.",
            'benh'      => $this->formatDisease($disease),
        ]);
    }

    /**
     * Xóa 1 bệnh qua AJAX — trả về JSON.
     */
    public function ajaxXoa(Disease $disease): JsonResponse
    {
        $name = $disease->name;

        // Xóa tất cả ảnh trong disk
        if (! empty($disease->images)) {
            foreach ($disease->images as $img) {
                Storage::disk('public')->delete($img);
            }
        } elseif ($disease->image) {
            Storage::disk('public')->delete($disease->image);
        }

        $disease->pesticides()->detach();
        $disease->delete();

        return response()->json([
            'success'   => true,
            'thong_bao' => "Đã xóa bệnh \"{$name}\" thành công.",
        ]);
    }

    /**
     * Xóa nhiều bệnh qua AJAX — trả về JSON.
     */
    public function ajaxXoaNhieu(Request $request): JsonResponse
    {
        $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:diseases,id'],
        ]);

        $ids   = $request->input('ids');
        $count = count($ids);

        $diseases = Disease::whereIn('id', $ids)->get();

        foreach ($diseases as $disease) {
            if (! empty($disease->images)) {
                foreach ($disease->images as $img) {
                    Storage::disk('public')->delete($img);
                }
            } elseif ($disease->image) {
                Storage::disk('public')->delete($disease->image);
            }
            $disease->pesticides()->detach();
        }

        Disease::whereIn('id', $ids)->delete();

        return response()->json([
            'success'   => true,
            'da_xoa'    => $count,
            'thong_bao' => "Đã xóa thành công {$count} bệnh.",
        ]);
    }

    /**
     * Helper format dữ liệu bệnh trả về JSON.
     */
    private function formatDisease(Disease $disease): array
    {
        return [
            'id'              => $disease->id,
            'name'            => $disease->name,
            'image_url'       => $disease->image_url,
            'images'          => $disease->images ?? ($disease->image ? [$disease->image] : []),
            'images_urls'     => $disease->images_urls,
            'symptoms'        => $disease->symptoms ?? '',
            'prevention'      => $disease->prevention ?? '',
            'treatment'       => $disease->treatment ?? '',
            'treatment_plans' => $disease->treatment_plans ?? [],
            'notes'           => $disease->notes ?? '',
            'pesticide_ids'   => $disease->pesticides->pluck('id')->toArray(),
            'pesticides'      => $disease->pesticides->map(fn ($p) => [
                'id'           => $p->id,
                'name'         => $p->name,
                'image_url'    => $p->image_url,
                'water_volume' => $p->water_volume,
            ])->toArray(),
            'url_cap_nhat'    => route('ajax.benh.cap-nhat', $disease),
            'url_xoa'         => route('ajax.benh.xoa', $disease),
        ];
    }

    /**
     * Xử lý và chuẩn hóa mảng treatment_plans từ request.
     */
    private function parseTreatmentPlans(mixed $input): ?array
    {
        if (empty($input)) {
            return null;
        }

        $raw = is_string($input) ? json_decode($input, true) : $input;
        if (! is_array($raw)) {
            return null;
        }

        $cleaned = [];
        foreach ($raw as $plan) {
            if (! is_array($plan)) {
                continue;
            }

            $groups = [];
            foreach ($plan['groups'] ?? [] as $g) {
                if (! is_array($g)) {
                    continue;
                }

                $primaryId = ! empty($g['primary_pesticide_id']) ? (int) $g['primary_pesticide_id'] : null;
                $substituteIds = [];
                if (! empty($g['substitute_ids'])) {
                    foreach ((array) $g['substitute_ids'] as $sid) {
                        if (! empty($sid)) {
                            $substituteIds[] = (int) $sid;
                        }
                    }
                }
                $substituteIds = array_values(array_unique($substituteIds));

                // Bỏ qua nếu cả thuốc chính và thuốc thay thế đều trống
                if (! $primaryId && empty($substituteIds)) {
                    continue;
                }

                $groups[] = [
                    'label'                => trim($g['label'] ?? ''),
                    'operator'             => $g['operator'] ?? '➕',
                    'primary_pesticide_id' => $primaryId,
                    'substitute_label'     => trim($g['substitute_label'] ?? 'Hoặc có thể chọn thay thế bằng:'),
                    'substitute_ids'       => $substituteIds,
                ];
            }

            $title = trim($plan['title'] ?? '');
            $badge = trim($plan['badge'] ?? '');
            $stage = trim($plan['stage'] ?? '');
            $dosageGuide = trim($plan['dosage_guide'] ?? '');
            $safetyNote = trim($plan['safety_note'] ?? '');

            // Nếu có ít nhất tên hoặc nhóm thuốc thì ghi nhận
            if (! empty($title) || ! empty($groups)) {
                $cleaned[] = [
                    'title'        => $title,
                    'badge'        => $badge,
                    'stage'        => $stage,
                    'dosage_guide' => $dosageGuide,
                    'safety_note'  => $safetyNote,
                    'groups'       => $groups,
                ];
            }
        }

        return ! empty($cleaned) ? $cleaned : null;
    }

    /**
     * Trích xuất tất cả ID thuốc được sử dụng trong các phác đồ.
     */
    private function extractPesticideIdsFromPlans(?array $plans): array
    {
        if (empty($plans)) {
            return [];
        }
        $ids = [];
        foreach ($plans as $p) {
            foreach ($p['groups'] ?? [] as $g) {
                if (! empty($g['primary_pesticide_id'])) {
                    $ids[] = (int) $g['primary_pesticide_id'];
                }
                if (! empty($g['substitute_ids'])) {
                    foreach ((array) $g['substitute_ids'] as $sid) {
                        $ids[] = (int) $sid;
                    }
                }
            }
        }
        return array_values(array_unique(array_filter($ids)));
    }
}
