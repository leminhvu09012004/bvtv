<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\View\View;

class TrangChuController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('pesticides')
            ->orderBy('sort_order')
            ->get();

        $totalPesticides = Pesticide::count();

        // Nạp toàn bộ sản phẩm kèm biến thể, tồn kho và danh mục để bộ lọc hoạt động đầy đủ
        $featuredProducts = Pesticide::with(['category', 'productVariants.inventories'])
            ->has('productVariants')
            ->get();

        $bestsellerProducts = Pesticide::with(['category', 'productVariants.inventories'])
            ->whereHas('productVariants', function ($q) {
                $q->where('selling_price', '>', 0);
            })
            ->latest('id')
            ->take(4)
            ->get();

        // Thống kê thuốc theo cây trồng chủ lực Tây Nguyên
        $cropStats = [
            'sau_rieng' => Pesticide::where('crops', 'like', '%Sầu riêng%')->count(),
            'ca_phe' => Pesticide::where('crops', 'like', '%Cà phê%')->count(),
            'ho_tieu' => Pesticide::where('crops', 'like', '%tiêu%')->count(),
            'chanh_day' => Pesticide::where('crops', 'like', '%Chanh dây%')->count(),
        ];

        return view('trang-chu.index', compact('categories', 'totalPesticides', 'cropStats', 'featuredProducts', 'bestsellerProducts'));
    }
}
