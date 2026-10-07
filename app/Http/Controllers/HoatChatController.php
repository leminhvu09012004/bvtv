<?php

namespace App\Http\Controllers;

use App\Services\HoatChatService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HoatChatController extends Controller
{
    protected HoatChatService $hoatChatService;

    public function __construct(HoatChatService $hoatChatService)
    {
        $this->hoatChatService = $hoatChatService;
    }

    /**
     * Trang hiển thị danh sách hoạt chất và các sản phẩm thuộc nhóm hợp chất đó.
     */
    public function index(Request $request): View
    {
        $data = $this->hoatChatService->getIngredientsData();

        $ingredients = $data['ingredients'];
        $chemicalGroups = $data['chemical_groups'];
        $statistics = $data['statistics'];

        $searchQuery = trim($request->input('q', ''));
        $selectedType = trim($request->input('type', 'all'));
        $viewMode = $request->input('view', 'ingredient'); // 'ingredient' hoặc 'group'

        return view('hoatchat.index', compact(
            'ingredients',
            'chemicalGroups',
            'statistics',
            'searchQuery',
            'selectedType',
            'viewMode'
        ));
    }
}
