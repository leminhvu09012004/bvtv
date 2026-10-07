<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Trang chủ hoạt động bình thường.
     */
    public function test_trang_chu_tra_ve_200(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
