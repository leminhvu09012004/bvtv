<?php

use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HoatChatController;
use App\Http\Controllers\MixingController;
use App\Http\Controllers\ThuocController;
use App\Http\Controllers\TrangChuController;
use Illuminate\Support\Facades\Route;

// Trang chủ
Route::get('/', [TrangChuController::class, 'index'])->name('home');

// === AJAX / API routes ===
Route::get('/ajax/tim-kiem', [ThuocController::class, 'ajaxTimKiem'])->name('ajax.tim-kiem');
Route::post('/ajax/them-nhanh', [ThuocController::class, 'ajaxThemNhanh'])->name('ajax.them-nhanh');
Route::delete('/ajax/xoa/{pesticide}', [ThuocController::class, 'ajaxXoa'])->name('ajax.xoa');
Route::delete('/ajax/xoa-nhieu', [ThuocController::class, 'ajaxXoaNhieu'])->name('ajax.xoa-nhieu');

// AJAX Danh mục
Route::post('/ajax/danh-muc', [DanhMucController::class, 'ajaxThem'])->name('ajax.danhmuc.them');
Route::put('/ajax/danh-muc/{category}', [DanhMucController::class, 'ajaxCapNhat'])->name('ajax.danhmuc.cap-nhat');
Route::delete('/ajax/danh-muc/{category}', [DanhMucController::class, 'ajaxXoa'])->name('ajax.danhmuc.xoa');
Route::delete('/ajax/danh-muc-nhieu', [DanhMucController::class, 'ajaxXoaNhieu'])->name('ajax.danhmuc.xoa-nhieu');

// Thuốc - xuất/nhập CSV (đặt trước resource để tránh conflict)
Route::get('/thuoc/xuat-csv', [ThuocController::class, 'xuatCSV'])->name('thuoc.xuat-csv');
Route::get('/thuoc/xuat-ten-san-pham', [ThuocController::class, 'xuatTenExcel'])->name('thuoc.xuat-ten');
Route::get('/thuoc/nhap-csv', [ThuocController::class, 'formImport'])->name('thuoc.nhap-csv');
Route::post('/thuoc/nhap-csv', [ThuocController::class, 'nhapCSV'])->name('thuoc.nhap-csv.luu');

// Thuốc - Tra cứu (Dành cho User / Chỉ xem)
Route::get('/thuoc', [ThuocController::class, 'index'])->name('thuoc.danh-sach');
Route::get('/tra-cuu-thuoc', [ThuocController::class, 'index'])->name('thuoc.tra-cuu');

// Hoạt chất & Nhóm Hợp chất - Tra cứu (Dành cho User)
Route::get('/hoat-chat', [HoatChatController::class, 'index'])->name('hoatchat.index');
Route::get('/tra-cuu-hoat-chat', [HoatChatController::class, 'index'])->name('hoatchat.tra-cuu');

// Phối trộn & Tương kỵ thuốc BVTV (Dành cho User)
Route::get('/ky-phoi-tron', [MixingController::class, 'index'])->name('phoi-tron.index');
Route::get('/tuong-ky-thuoc', [MixingController::class, 'index'])->name('phoi-tron.tuong-ky');
Route::post('/ajax/kiem-tra-phoi-tron', [MixingController::class, 'ajaxCheck'])->name('ajax.kiem-tra-phoi-tron');
Route::post('/ajax/kiem-tra-phoi-tron-danh-muc', [MixingController::class, 'ajaxCategoryCheck'])->name('ajax.kiem-tra-phoi-tron-danh-muc');

// Thuốc - Quản lý CRUD (Dành cho Admin)
Route::get('/quan-ly/thuoc', [ThuocController::class, 'quanLy'])->name('thuoc.quan-ly');
Route::get('/thuoc/them-moi', [ThuocController::class, 'them'])->name('thuoc.them');
Route::post('/thuoc', [ThuocController::class, 'luu'])->name('thuoc.luu');
Route::get('/thuoc/{pesticide}', [ThuocController::class, 'xem'])->name('thuoc.xem');
Route::get('/thuoc/{pesticide}/chinh-sua', [ThuocController::class, 'sua'])->name('thuoc.sua');
Route::put('/thuoc/{pesticide}', [ThuocController::class, 'capNhat'])->name('thuoc.cap-nhat');
Route::delete('/thuoc/{pesticide}', [ThuocController::class, 'xoa'])->name('thuoc.xoa');

// Danh mục - Quản lý CRUD
Route::get('/danh-muc', [DanhMucController::class, 'index'])->name('danhmuc.danh-sach');
Route::post('/danh-muc', [DanhMucController::class, 'luu'])->name('danhmuc.luu');
Route::put('/danh-muc/{category}', [DanhMucController::class, 'capNhat'])->name('danhmuc.cap-nhat');
Route::delete('/danh-muc/{category}', [DanhMucController::class, 'xoa'])->name('danhmuc.xoa');
Route::get('/danh-muc/{slug}', [DanhMucController::class, 'xem'])->name('danhmuc.xem');

// Các bài thuốc - Tra cứu (Dành cho User / Chỉ xem)
Route::get('/benh', [DiseaseController::class, 'index'])->name('benh.danh-sach');
Route::get('/bai-thuoc', [DiseaseController::class, 'index'])->name('benh.tra-cuu');

// Các bài thuốc - Quản lý CRUD (Dành cho Admin)
Route::get('/quan-ly/benh', [DiseaseController::class, 'quanLy'])->name('benh.quan-ly');
Route::get('/quan-ly/bai-thuoc', [DiseaseController::class, 'quanLy'])->name('benh.quan-ly-bai-thuoc');

// AJAX Bệnh
Route::post('/ajax/benh', [DiseaseController::class, 'ajaxThem'])->name('ajax.benh.them');
Route::post('/ajax/benh/{disease}', [DiseaseController::class, 'ajaxCapNhat'])->name('ajax.benh.cap-nhat');
Route::delete('/ajax/benh/{disease}', [DiseaseController::class, 'ajaxXoa'])->name('ajax.benh.xoa');
Route::delete('/ajax/benh-nhieu', [DiseaseController::class, 'ajaxXoaNhieu'])->name('ajax.benh.xoa-nhieu');
