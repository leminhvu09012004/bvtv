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

        // Thống kê thuốc theo cây trồng chủ lực Tây Nguyên
        $cropStats = [
            'sau_rieng' => Pesticide::where('crops', 'like', '%Sầu riêng%')->count(),
            'ca_phe' => Pesticide::where('crops', 'like', '%Cà phê%')->count(),
            'ho_tieu' => Pesticide::where('crops', 'like', '%tiêu%')->count(),
            'chanh_day' => Pesticide::where('crops', 'like', '%Chanh dây%')->count(),
            'cay_khac' => Pesticide::where(function ($q) {
                $q->where('crops', 'like', '%Bơ%')->orWhere('crops', 'like', '%Mắc ca%');
            })->count(),
        ];

        return view('trang-chu.index', compact('categories', 'totalPesticides', 'cropStats'));
    }
}
