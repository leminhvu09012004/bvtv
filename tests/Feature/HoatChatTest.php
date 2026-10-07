<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoatChatTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🛡️',
        ]);

        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Thuốc Mancozeb Xanh Mới',
            'active_ingredient' => 'Mancozeb 800g/kg',
            'water_volume' => '400 lít nước',
            'form_type' => 'WP',
        ]);

        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Thuốc Trừ Nấm Dimethor',
            'active_ingredient' => 'Dimethomorph 500g/l',
            'water_volume' => '200 lít nước',
            'form_type' => 'SC',
        ]);
    }

    public function test_trang_hoat_chat_tai_thanh_cong(): void
    {
        $response = $this->get(route('hoatchat.index'));

        $response->assertStatus(200);
        $response->assertSee('Tra Cứu Hoạt Chất');
        $response->assertSee('Mancozeb');
        $response->assertSee('Dimethomorph');
        $response->assertSee('Thuốc Mancozeb Xanh Mới');
        $response->assertSee('Thuốc Trừ Nấm Dimethor');
    }

    public function test_alias_tra_cuu_hoat_chat_tai_thanh_cong(): void
    {
        $response = $this->get(route('hoatchat.tra-cuu'));

        $response->assertStatus(200);
        $response->assertSee('Mancozeb');
    }

    public function test_tim_kiem_hoat_chat_qua_query(): void
    {
        $response = $this->get(route('hoatchat.index', ['q' => 'mancozeb']));

        $response->assertStatus(200);
        $response->assertSee('Mancozeb');
    }
}
