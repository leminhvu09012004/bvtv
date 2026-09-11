<?php

use App\Http\Controllers\DanhMucController;
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
Route::get('/thuoc/nhap-csv', [ThuocController::class, 'formImport'])->name('thuoc.nhap-csv');
Route::post('/thuoc/nhap-csv', [ThuocController::class, 'nhapCSV'])->name('thuoc.nhap-csv.luu');

// Thuốc - CRUD
Route::get('/thuoc', [ThuocController::class, 'index'])->name('thuoc.danh-sach');
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
