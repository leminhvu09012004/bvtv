<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pesticide;
use App\Services\MixingCompatibilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MixingController extends Controller
{
    protected MixingCompatibilityService $mixingService;

    public function __construct(MixingCompatibilityService $mixingService)
    {
        $this->mixingService = $mixingService;
    }

    /**
     * Trang cẩm nang & tra cứu kiểm tra phối trộn thuốc BVTV.
     */
    public function index(Request $request): View
    {
        $pesticides = Pesticide::with('category')
            ->select('id', 'name', 'active_ingredient', 'category_id', 'form_type', 'image')
            ->orderBy('name')
            ->get();

        $categories = Category::withCount('pesticides')->orderBy('sort_order')->get();

        $matrixData = $this->mixingService->getRulesMatrix();
        $guideData = $this->mixingService->getMixingOrderGuide();

        // 1. Kiểm tra xem có thuốc truyền sẵn qua query param không (ví dụ từ trang chi tiết)
        $initialP1 = $request->query('p1') ? $pesticides->firstWhere('id', (int)$request->query('p1')) : null;
        $initialP2 = $request->query('p2') ? $pesticides->firstWhere('id', (int)$request->query('p2')) : null;

        $initialResult = null;
        if ($initialP1 && $initialP2) {
            $initialResult = $this->mixingService->checkPair($initialP1, $initialP2);
        }

        // 2. Kiểm tra xem có danh mục truyền sẵn qua query param không
        $initialCat1Id = $request->query('cat1') ? (int)$request->query('cat1') : null;
        $initialCat2Id = $request->query('cat2') ? (int)$request->query('cat2') : null;

        $initialCatResult = null;
        if ($initialCat1Id && $initialCat2Id) {
            $catRes = $this->mixingService->checkCategoryCompatibility($initialCat1Id, $initialCat2Id);
            if ($catRes['status'] !== 'empty' && isset($catRes['category_1'], $catRes['category_2'])) {
                $initialCatResult = $catRes;
            }
        }

        $sampleProducts = $pesticides->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'active' => $p->active_ingredient,
            'cat' => $p->category?->slug,
        ]);

        return view('phoi-tron.index', compact(
            'pesticides',
            'categories',
            'matrixData',
            'guideData',
            'initialP1',
            'initialP2',
            'initialResult',
            'initialCat1Id',
            'initialCat2Id',
            'initialCatResult',
            'sampleProducts'
        ));
    }

    /**
     * AJAX API: Kiểm tra tương kỵ giữa các thuốc được chọn.
     */
    public function ajaxCheck(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            $p1 = $request->input('p1');
            $p2 = $request->input('p2');
            if ($p1 && $p2) {
                $ids = [(int)$p1, (int)$p2];
            }
        }

        if (count($ids) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn ít nhất 2 sản phẩm thuốc để phân tích tương kỵ.',
            ], 422);
        }

        $result = $this->mixingService->checkCompatibility($ids);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * AJAX API: Kiểm tra tương kỵ giữa 2 Danh Mục sản phẩm.
     */
    public function ajaxCategoryCheck(Request $request): JsonResponse
    {
        $cat1Id = (int)$request->input('cat1_id');
        $cat2Id = (int)$request->input('cat2_id');

        if (!$cat1Id || !$cat2Id) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn đầy đủ 2 danh mục để phân tích.',
            ], 422);
        }

        $result = $this->mixingService->checkCategoryCompatibility($cat1Id, $cat2Id);
        $html = view('phoi-tron._ket-qua-category-partial', ['catResult' => $result])->render();

        return response()->json([
            'success' => true,
            'data' => $result,
            'html' => $html,
        ]);
    }
}
