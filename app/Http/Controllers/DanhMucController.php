<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DanhMucController extends Controller
{
    /**
     * Danh sách tất cả danh mục (Trang Quản lý danh mục).
     */
    public function index(): View
    {
        $categories = Category::withCount('pesticides')
            ->orderBy('sort_order')
            ->get();

        return view('danhmuc.danh-sach', compact('categories'));
    }

    /**
     * Thêm danh mục mới (Form web).
     */
    public function luu(Request $request): RedirectResponse
    {
        $category = $this->storeCategory($request);

        return redirect()->route('danhmuc.danh-sach')
            ->with('success', "Đã thêm danh mục \"{$category->name}\" thành công.");
    }

    /**
     * Thêm danh mục mới qua AJAX — trả về JSON.
     */
    public function ajaxThem(Request $request): JsonResponse
    {
        $category = $this->storeCategory($request);
        $category->loadCount('pesticides');

        return response()->json([
            'success' => true,
            'thong_bao' => "Đã thêm danh mục \"{$category->name}\" thành công.",
            'danh_muc' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'emoji' => $category->emoji,
                'description' => $category->description ?? '',
                'sort_order' => $category->sort_order,
                'pesticides_count' => $category->pesticides_count,
                'url_xem' => route('danhmuc.xem', $category->slug),
                'url_cap_nhat' => route('ajax.danhmuc.cap-nhat', $category),
                'url_xoa' => route('ajax.danhmuc.xoa', $category),
            ],
        ], 201);
    }

    /**
     * Cập nhật danh mục (Form web).
     */
    public function capNhat(Request $request, Category $category): RedirectResponse
    {
        $this->updateCategory($request, $category);

        return redirect()->route('danhmuc.danh-sach')
            ->with('success', "Đã cập nhật danh mục \"{$category->name}\" thành công.");
    }

    /**
     * Cập nhật danh mục qua AJAX — trả về JSON.
     */
    public function ajaxCapNhat(Request $request, Category $category): JsonResponse
    {
        $this->updateCategory($request, $category);
        $category->loadCount('pesticides');

        return response()->json([
            'success' => true,
            'thong_bao' => "Đã cập nhật danh mục \"{$category->name}\" thành công.",
            'danh_muc' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'emoji' => $category->emoji,
                'description' => $category->description ?? '',
                'sort_order' => $category->sort_order,
                'pesticides_count' => $category->pesticides_count,
                'url_xem' => route('danhmuc.xem', $category->slug),
                'url_cap_nhat' => route('ajax.danhmuc.cap-nhat', $category),
                'url_xoa' => route('ajax.danhmuc.xoa', $category),
            ],
        ]);
    }

    /**
     * Xóa danh mục (Form web).
     */
    public function xoa(Category $category): RedirectResponse
    {
        $name = $category->name;
        // Xóa các thuốc thuộc danh mục trước (nếu có) rồi xóa danh mục
        $category->pesticides()->delete();
        $category->delete();

        return redirect()->route('danhmuc.danh-sach')
            ->with('success', "Đã xóa danh mục \"{$name}\" thành công.");
    }

    /**
     * Xóa danh mục qua AJAX — trả về JSON.
     */
    public function ajaxXoa(Category $category): JsonResponse
    {
        $name = $category->name;
        $pesticidesCount = $category->pesticides()->count();

        // Xóa thuốc thuộc danh mục nếu có
        if ($pesticidesCount > 0) {
            $category->pesticides()->delete();
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'thong_bao' => "Đã xóa danh mục \"{$name}\"".($pesticidesCount > 0 ? " và {$pesticidesCount} thuốc liên quan" : '').' thành công.',
        ]);
    }

    /**
     * Xóa nhiều danh mục qua AJAX — trả về JSON.
     */
    public function ajaxXoaNhieu(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:categories,id'],
        ]);

        $ids = $request->input('ids');
        $count = count($ids);

        // Xóa các thuốc thuộc các danh mục này trước
        Pesticide::whereIn('category_id', $ids)->delete();

        // Xóa các danh mục
        Category::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'da_xoa' => $count,
            'thong_bao' => "Đã xóa thành công {$count} danh mục.",
        ]);
    }

    /**
     * Chi tiết danh mục (xem danh sách thuốc thuộc danh mục).
     */
    public function xem(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $pesticides = $category->pesticides()->orderBy('name')->get();

        return view('danhmuc.chi-tiet', compact('category', 'pesticides'));
    }

    /**
     * Helper tạo Category.
     */
    private function storeCategory(Request $request): Category
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'emoji' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'emoji' => $validated['emoji'] ?: '📦',
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? (Category::max('sort_order') + 1),
        ]);
    }

    /**
     * Helper cập nhật Category.
     */
    private function updateCategory(Request $request, Category $category): Category
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'emoji' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ]);

        $slug = $category->slug;
        if ($category->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'emoji' => $validated['emoji'] ?: '📦',
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? $category->sort_order,
        ]);

        return $category;
    }
}
