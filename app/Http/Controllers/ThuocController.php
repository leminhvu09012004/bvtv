<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ThuocController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pesticide::with('category')->search($request->input('q'));

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('cay_trong')) {
            $query->where('crops', 'like', '%'.$request->input('cay_trong').'%');
        }

        if ($request->filled('hoat_chat')) {
            $query->where('active_ingredient', 'like', '%'.$request->input('hoat_chat').'%');
        }

        $pesticides = $query->orderBy('name')->paginate(20)->withQueryString();
        $categories = Category::orderBy('sort_order')->get();

        return view('thuoc.danh-sach', compact('pesticides', 'categories'));
    }

    public function them(Request $request): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $selectedCategoryId = $request->input('category_id');

        return view('thuoc.them-moi', compact('categories', 'selectedCategoryId'));
    }

    public function luu(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:191'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'active_ingredient' => ['nullable', 'string', 'max:191'],
            'concentration' => ['nullable', 'string', 'max:191'],
            'usage' => ['nullable', 'string'],
            'target' => ['nullable', 'string'],
            'crops' => ['nullable', 'string'],
            'form_type' => ['nullable', 'string', 'max:50'],
            'manufacturer' => ['nullable', 'string', 'max:191'],
            'registration_number' => ['nullable', 'string', 'max:191'],
            'isolation_period' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pesticides', 'public');
        }

        $pesticide = Pesticide::create($validated);

        return redirect()->route('thuoc.xem', $pesticide)
            ->with('success', 'Đã thêm thuốc "'.$pesticide->name.'" thành công!');
    }

    public function xem(Pesticide $pesticide): View
    {
        $pesticide->load('category');

        return view('thuoc.chi-tiet', compact('pesticide'));
    }

    public function sua(Pesticide $pesticide): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('thuoc.chinh-sua', compact('pesticide', 'categories'));
    }

    public function capNhat(Request $request, Pesticide $pesticide): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:191'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'xoa_anh' => ['nullable', 'boolean'],
            'active_ingredient' => ['nullable', 'string', 'max:191'],
            'concentration' => ['nullable', 'string', 'max:191'],
            'usage' => ['nullable', 'string'],
            'target' => ['nullable', 'string'],
            'crops' => ['nullable', 'string'],
            'form_type' => ['nullable', 'string', 'max:50'],
            'manufacturer' => ['nullable', 'string', 'max:191'],
            'registration_number' => ['nullable', 'string', 'max:191'],
            'isolation_period' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($request->boolean('xoa_anh')) {
            if ($pesticide->image && Storage::disk('public')->exists($pesticide->image)) {
                Storage::disk('public')->delete($pesticide->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($pesticide->image && Storage::disk('public')->exists($pesticide->image)) {
                Storage::disk('public')->delete($pesticide->image);
            }
            $validated['image'] = $request->file('image')->store('pesticides', 'public');
        }

        unset($validated['xoa_anh']);
        $pesticide->update($validated);

        return redirect()->route('thuoc.xem', $pesticide)
            ->with('success', 'Đã cập nhật thuốc "'.$pesticide->name.'" thành công!');
    }

    public function xoa(Pesticide $pesticide): RedirectResponse
    {
        $name = $pesticide->name;
        $categorySlug = $pesticide->category->slug ?? null;

        if ($pesticide->image && Storage::disk('public')->exists($pesticide->image)) {
            Storage::disk('public')->delete($pesticide->image);
        }

        $pesticide->delete();

        $redirect = $categorySlug
            ? redirect()->route('danhmuc.xem', $categorySlug)
            : redirect()->route('thuoc.danh-sach');

        return $redirect->with('success', 'Đã xóa thuốc "'.$name.'".');
    }

    /**
     * Xuất tất cả thuốc ra file CSV.
     */
    public function xuatCSV(): Response
    {
        $pesticides = Pesticide::with('category')->orderBy('category_id')->orderBy('name')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="thuoc-bvtv-'.now()->format('Ymd').'.csv"',
        ];

        $callback = function () use ($pesticides) {
            $handle = fopen('php://output', 'w');

            // BOM for UTF-8 Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'STT',
                'Danh mục',
                'Tên thuốc',
                'Hoạt chất',
                'Hàm lượng',
                'Công dụng',
                'Đối tượng phòng/trừ',
                'Cây trồng',
                'Dạng thuốc',
                'Nhà sản xuất',
                'Số đăng ký',
                'Thời gian cách ly',
                'Ghi chú',
            ]);

            foreach ($pesticides as $i => $p) {
                fputcsv($handle, [
                    $i + 1,
                    $p->category?->name ?? '',
                    $p->name,
                    $p->active_ingredient ?? '',
                    $p->concentration ?? '',
                    $p->usage ?? '',
                    $p->target ?? '',
                    $p->crops ?? '',
                    $p->form_type ?? '',
                    $p->manufacturer ?? '',
                    $p->registration_number ?? '',
                    $p->isolation_period ?? '',
                    $p->notes ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Hiển thị form import CSV.
     */
    public function formImport(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('thuoc.nhap-csv', compact('categories'));
    }

    /**
     * Xử lý import CSV.
     */
    public function nhapCSV(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Bỏ qua BOM UTF-8
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        // Bỏ qua dòng tiêu đề
        fgetcsv($handle);

        $imported = 0;
        $errors = [];
        $categoryMap = Category::orderBy('sort_order')->get()->keyBy('name');

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 3) {
                continue;
            }

            $categoryName = trim($row[1] ?? '');
            $category = $categoryMap->get($categoryName);

            if (! $category) {
                $errors[] = 'Dòng '.($imported + 2).': Không tìm thấy danh mục "'.$categoryName.'"';

                continue;
            }

            Pesticide::create([
                'category_id' => $category->id,
                'name' => trim($row[2] ?? ''),
                'active_ingredient' => trim($row[3] ?? '') ?: null,
                'concentration' => trim($row[4] ?? '') ?: null,
                'usage' => trim($row[5] ?? '') ?: null,
                'target' => trim($row[6] ?? '') ?: null,
                'crops' => trim($row[7] ?? '') ?: null,
                'form_type' => trim($row[8] ?? '') ?: null,
                'manufacturer' => trim($row[9] ?? '') ?: null,
                'registration_number' => trim($row[10] ?? '') ?: null,
                'isolation_period' => trim($row[11] ?? '') ?: null,
                'notes' => trim($row[12] ?? '') ?: null,
            ]);

            $imported++;
        }

        fclose($handle);

        $message = "Đã import {$imported} sản phẩm thành công.";
        if ($errors) {
            $message .= ' Lỗi: '.implode(' | ', array_slice($errors, 0, 3));
        }

        return redirect()->route('thuoc.danh-sach')->with('success', $message);
    }

    // =========================================================================
    // AJAX methods
    // =========================================================================

    /**
     * Tìm kiếm trực tiếp (live search) — trả về JSON.
     */
    public function ajaxTimKiem(Request $request): JsonResponse
    {
        $query = Pesticide::with('category')->search($request->input('q'));

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('cay_trong')) {
            $query->where('crops', 'like', '%'.$request->input('cay_trong').'%');
        }

        if ($request->filled('hoat_chat')) {
            $query->where('active_ingredient', 'like', '%'.$request->input('hoat_chat').'%');
        }

        $results = $query->orderBy('name')
            ->limit(50)
            ->get()
            ->map(fn (Pesticide $p) => [
                'id' => $p->id,
                'ten' => $p->name,
                'image_url' => $p->image_url,
                'hoat_chat' => $p->active_ingredient,
                'ham_luong' => $p->concentration,
                'cong_dung' => $p->usage,
                'cay_trong' => $p->crops,
                'danh_muc' => $p->category?->name,
                'danh_muc_emoji' => $p->category?->emoji,
                'danh_muc_slug' => $p->category?->slug,
                'url_xem' => route('thuoc.xem', $p),
                'url_sua' => route('thuoc.sua', $p),
                'url_xoa' => route('ajax.xoa', $p),
            ]);

        return response()->json([
            'total' => $results->count(),
            'data' => $results,
        ]);
    }

    /**
     * Thêm nhanh qua AJAX — trả về JSON.
     */
    public function ajaxThemNhanh(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:191'],
            'active_ingredient' => ['nullable', 'string', 'max:191'],
            'usage' => ['nullable', 'string'],
            'crops' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $pesticide = Pesticide::create($validated);
        $pesticide->load('category');

        return response()->json([
            'success' => true,
            'thong_bao' => 'Đã thêm thuốc "'.$pesticide->name.'" thành công!',
            'thuoc' => [
                'id' => $pesticide->id,
                'ten' => $pesticide->name,
                'image_url' => $pesticide->image_url,
                'hoat_chat' => $pesticide->active_ingredient,
                'cong_dung' => $pesticide->usage,
                'cay_trong' => $pesticide->crops,
                'danh_muc' => $pesticide->category?->name,
                'danh_muc_emoji' => $pesticide->category?->emoji,
                'danh_muc_slug' => $pesticide->category?->slug,
                'url_xem' => route('thuoc.xem', $pesticide),
                'url_sua' => route('thuoc.sua', $pesticide),
                'url_xoa' => route('ajax.xoa', $pesticide),
            ],
        ]);
    }

    /**
     * Xóa thuốc qua AJAX — trả về JSON.
     */
    public function ajaxXoa(Pesticide $pesticide): JsonResponse
    {
        $name = $pesticide->name;

        if ($pesticide->image && Storage::disk('public')->exists($pesticide->image)) {
            Storage::disk('public')->delete($pesticide->image);
        }

        $pesticide->delete();

        return response()->json([
            'success' => true,
            'thong_bao' => 'Đã xóa thuốc "'.$name.'".',
        ]);
    }

    /**
     * Xóa nhiều thuốc cùng lúc qua AJAX — trả về JSON.
     */
    public function ajaxXoaNhieu(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:pesticides,id'],
        ]);

        $ids = $request->input('ids');
        $pesticides = Pesticide::whereIn('id', $ids)->get();
        $soLuong = $pesticides->count();

        foreach ($pesticides as $p) {
            if ($p->image && Storage::disk('public')->exists($p->image)) {
                Storage::disk('public')->delete($p->image);
            }
            $p->delete();
        }

        return response()->json([
            'success' => true,
            'da_xoa' => $soLuong,
            'thong_bao' => "Đã xóa {$soLuong} sản phẩm.",
        ]);
    }
}
