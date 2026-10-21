<?php

use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\Engineer\DiseaseEngineerController;
use App\Http\Controllers\HoatChatController;
use App\Http\Controllers\MixingController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ThuocController;
use App\Http\Controllers\TrangChuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION & TÀI KHOẢN (Guest & Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.post');
    Route::get('/dang-ky', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/dang-ky', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Hồ sơ nông dân / khách hàng
Route::middleware(['auth', 'role:customer,admin'])->group(function () {
    Route::get('/tai-khoan', [CustomerAccountController::class, 'index'])->name('customer.account');
    Route::post('/ajax/tai-khoan/cap-nhat', [CustomerAccountController::class, 'ajaxUpdateProfile'])->name('ajax.tai-khoan.cap-nhat');
});

/*
|--------------------------------------------------------------------------
| 2. CUSTOMER STOREFRONT & E-COMMERCE (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [TrangChuController::class, 'index'])->name('home');
Route::get('/gio-hang', [CheckoutController::class, 'cart'])->name('cart.index');
Route::get('/thanh-toan', [CheckoutController::class, 'checkout'])->name('checkout.index');
Route::post('/thanh-toan', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/don-hang/{code}', [CheckoutController::class, 'orderSuccess'])->name('don-hang.thanh-cong');

// Customer Cart AJAX
Route::post('/ajax/cart/add', [CheckoutController::class, 'ajaxAdd'])->name('ajax.cart.add');
Route::post('/ajax/cart/update', [CheckoutController::class, 'ajaxUpdate'])->name('ajax.cart.update');
Route::post('/ajax/cart/remove', [CheckoutController::class, 'ajaxRemove'])->name('ajax.cart.remove');
Route::get('/ajax/cart/summary', [CheckoutController::class, 'ajaxSummary'])->name('ajax.cart.summary');

/*
|--------------------------------------------------------------------------
| 3. SỔ TAY KỸ THUẬT & TRA CỨU HỌC TẬP (Public / Study)
|--------------------------------------------------------------------------
*/
// Thuốc BVTV - Tra cứu
Route::get('/thuoc', [ThuocController::class, 'index'])->name('thuoc.danh-sach');
Route::get('/tra-cuu-thuoc', [ThuocController::class, 'index'])->name('thuoc.tra-cuu');
Route::get('/thuoc/{pesticide}', [ThuocController::class, 'xem'])->name('thuoc.xem')->whereNumber('pesticide');

// Hoạt chất & Nhóm Hợp chất & Bệnh hại (Chỉ dành riêng cho Phân hệ Kỹ sư & Admin)
Route::middleware(['auth', 'role:engineer'])->group(function () {
    Route::get('/hoat-chat', [HoatChatController::class, 'index'])->name('hoatchat.index');
    Route::get('/tra-cuu-hoat-chat', [HoatChatController::class, 'index'])->name('hoatchat.tra-cuu');

    // Phân hệ Bệnh hại & Phác đồ điều trị cây trồng (Kỹ Sư)
    Route::get('/ky-su/benh-hai', [DiseaseEngineerController::class, 'index'])->name('engineer.benh.index');
    Route::get('/ky-su/benh-hai/{disease}', [DiseaseEngineerController::class, 'chiTiet'])->name('engineer.benh.chi-tiet');
    Route::get('/ky-su/benh-hai/{disease}/chinh-sua', [DiseaseEngineerController::class, 'edit'])->name('engineer.benh.edit');
    Route::get('/ajax/ky-su/benh/{disease}', [DiseaseEngineerController::class, 'ajaxShow'])->name('engineer.benh.show');
    Route::post('/ajax/ky-su/benh', [DiseaseEngineerController::class, 'ajaxStore'])->name('engineer.benh.store');
    Route::post('/ajax/ky-su/benh/{disease}', [DiseaseEngineerController::class, 'ajaxUpdate'])->name('engineer.benh.update');
    Route::delete('/ajax/ky-su/benh/{disease}', [DiseaseEngineerController::class, 'ajaxDestroy'])->name('engineer.benh.destroy');
    Route::post('/ajax/ky-su/benh/{disease}/xoa-anh', [DiseaseEngineerController::class, 'ajaxDeleteImage'])->name('engineer.benh.delete-image');
    Route::post('/ajax/ky-su/benh/{disease}/tai-anh', [DiseaseEngineerController::class, 'ajaxUploadImage'])->name('engineer.benh.upload-image');
    Route::post('/ajax/ky-su/benh/{disease}/dat-anh-chinh', [DiseaseEngineerController::class, 'ajaxSetPrimaryImage'])->name('engineer.benh.set-primary-image');
    Route::post('/ajax/ky-su/benh/{disease}/auto-sync-thuoc', [DiseaseEngineerController::class, 'ajaxAutoSyncThuoc'])->name('engineer.benh.auto-sync-thuoc');
    Route::post('/ajax/ky-su/benh/{disease}/gan-thuoc', [DiseaseEngineerController::class, 'ajaxGanThuoc'])->name('engineer.benh.gan-thuoc');
    Route::post('/ajax/ky-su/tim-thuoc-theo-hoat-chat', [DiseaseEngineerController::class, 'ajaxTimThuocTheoHoatChat'])->name('engineer.benh.tim-thuoc-hoat-chat');
});

// Phối trộn & Quản lý tính kháng (Study / Engineer)
Route::get('/ky-phoi-tron', [MixingController::class, 'index'])->name('phoi-tron.index');
Route::get('/tuong-ky-thuoc', [MixingController::class, 'index'])->name('phoi-tron.tuong-ky');
Route::post('/ajax/kiem-tra-phoi-tron', [MixingController::class, 'ajaxCheck'])->name('ajax.kiem-tra-phoi-tron');
Route::post('/ajax/kiem-tra-phoi-tron-danh-muc', [MixingController::class, 'ajaxCategoryCheck'])->name('ajax.kiem-tra-phoi-tron-danh-muc');

// Bài thuốc & Sâu bệnh
Route::get('/benh', [DiseaseController::class, 'index'])->name('benh.danh-sach');
Route::get('/bai-thuoc', [DiseaseController::class, 'index'])->name('benh.tra-cuu');

// Danh mục xem công khai
Route::get('/danh-muc', [DanhMucController::class, 'index'])->name('danhmuc.danh-sach');
Route::get('/danh-muc/{slug}', [DanhMucController::class, 'xem'])->name('danhmuc.xem');

// AJAX Tra cứu nhanh
Route::get('/ajax/tim-kiem', [ThuocController::class, 'ajaxTimKiem'])->name('ajax.tim-kiem');

/*
|--------------------------------------------------------------------------
| 4. BÁN HÀNG NHANH TẠI QUẦY (STAFF POS - Role: staff, admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/ajax/pos/search', [PosController::class, 'search'])->name('pos.search');
    Route::post('/ajax/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
});

/*
|--------------------------------------------------------------------------
| 5. QUẢN TRỊ HỆ THỐNG & KHO ĐA ĐIỂM (ADMIN - Role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Quản lý kho đa điểm & sổ cái bất biến
    Route::prefix('quan-ly/kho')->name('admin.inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/so-cai', [InventoryController::class, 'movements'])->name('movements');
        Route::get('/chuyen-kho', [InventoryController::class, 'transfers'])->name('transfers');
        Route::post('/chuyen-kho', [InventoryController::class, 'storeTransfer'])->name('transfers.store');
        Route::post('/chuyen-kho/{transfer}/xuat', [InventoryController::class, 'dispatchTransfer'])->name('transfers.dispatch');
        Route::post('/chuyen-kho/{transfer}/nhan', [InventoryController::class, 'receiveTransfer'])->name('transfers.receive');
        Route::get('/nhap-kho', [InventoryController::class, 'receipts'])->name('receipts');
        Route::post('/nhap-kho', [InventoryController::class, 'storeReceipt'])->name('receipts.store');
        Route::post('/nhap-kho/{receipt}/duyet', [InventoryController::class, 'approveReceipt'])->name('receipts.approve');
        Route::get('/xuat-kho', [InventoryController::class, 'issues'])->name('issues');
        Route::post('/xuat-kho', [InventoryController::class, 'storeIssue'])->name('issues.store');
        Route::post('/xuat-kho/{issue}/duyet', [InventoryController::class, 'approveIssue'])->name('issues.approve');
        Route::get('/xuat-kho/{issue}/in', [InventoryController::class, 'printIssue'])->name('issues.print');
        Route::get('/kiem-ke', [InventoryController::class, 'counts'])->name('counts');
        Route::post('/kiem-ke/{count}/can-doi', [InventoryController::class, 'reconcileCount'])->name('counts.reconcile');
        Route::get('/ajax/tim-kiem-san-pham', [InventoryController::class, 'ajaxSearchVariants'])->name('ajax.variants.search');
    });

    // Quản lý chi nhánh / kho hàng CRUD
    Route::prefix('quan-ly/chi-nhanh')->name('admin.warehouses.')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::post('/', [WarehouseController::class, 'store'])->name('store');
        Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update');
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
        Route::post('/{warehouse}/toggle', [WarehouseController::class, 'toggle'])->name('toggle');
    });

    // Quản lý thuốc CRUD
    Route::get('/quan-ly/thuoc', [ThuocController::class, 'quanLy'])->name('thuoc.quan-ly');
    Route::get('/thuoc/them-moi', [ThuocController::class, 'them'])->name('thuoc.them');
    Route::post('/thuoc', [ThuocController::class, 'luu'])->name('thuoc.luu');
    Route::get('/thuoc/{pesticide}/chinh-sua', [ThuocController::class, 'sua'])->name('thuoc.sua');
    Route::put('/thuoc/{pesticide}', [ThuocController::class, 'capNhat'])->name('thuoc.cap-nhat');
    Route::delete('/thuoc/{pesticide}', [ThuocController::class, 'xoa'])->name('thuoc.xoa');

    // Thuốc - xuất/nhập CSV & Excel
    Route::get('/thuoc/xuat-csv', [ThuocController::class, 'xuatCSV'])->name('thuoc.xuat-csv');
    Route::get('/thuoc/xuat-ten-san-pham', [ThuocController::class, 'xuatTenExcel'])->name('thuoc.xuat-ten');
    Route::get('/thuoc/nhap-csv', [ThuocController::class, 'formImport'])->name('thuoc.nhap-csv');
    Route::post('/thuoc/nhap-csv', [ThuocController::class, 'nhapCSV'])->name('thuoc.nhap-csv.luu');

    // Danh mục - Thêm / Sửa / Xóa
    Route::post('/danh-muc', [DanhMucController::class, 'luu'])->name('danhmuc.luu');
    Route::put('/danh-muc/{category}', [DanhMucController::class, 'capNhat'])->name('danhmuc.cap-nhat');
    Route::delete('/danh-muc/{category}', [DanhMucController::class, 'xoa'])->name('danhmuc.xoa');

    // Quản lý Bệnh & Bài thuốc
    Route::get('/quan-ly/benh', [DiseaseController::class, 'quanLy'])->name('benh.quan-ly');
    Route::get('/quan-ly/bai-thuoc', [DiseaseController::class, 'quanLy'])->name('benh.quan-ly-bai-thuoc');

    // AJAX Quản trị CRUD
    Route::post('/ajax/them-nhanh', [ThuocController::class, 'ajaxThemNhanh'])->name('ajax.them-nhanh');
    Route::put('/ajax/thuoc/{pesticide}/quick-update', [ThuocController::class, 'ajaxCapNhatNhanh'])->name('ajax.thuoc.quick-update');
    Route::delete('/ajax/xoa/{pesticide}', [ThuocController::class, 'ajaxXoa'])->name('ajax.xoa');
    Route::delete('/ajax/xoa-nhieu', [ThuocController::class, 'ajaxXoaNhieu'])->name('ajax.xoa-nhieu');

    Route::post('/ajax/danh-muc', [DanhMucController::class, 'ajaxThem'])->name('ajax.danhmuc.them');
    Route::put('/ajax/danh-muc/{category}', [DanhMucController::class, 'ajaxCapNhat'])->name('ajax.danhmuc.cap-nhat');
    Route::delete('/ajax/danh-muc/{category}', [DanhMucController::class, 'ajaxXoa'])->name('ajax.danhmuc.xoa');
    Route::delete('/ajax/danh-muc-nhieu', [DanhMucController::class, 'ajaxXoaNhieu'])->name('ajax.danhmuc.xoa-nhieu');

    Route::post('/ajax/benh', [DiseaseController::class, 'ajaxThem'])->name('ajax.benh.them');
    Route::post('/ajax/benh/{disease}', [DiseaseController::class, 'ajaxCapNhat'])->name('ajax.benh.cap-nhat');
    Route::delete('/ajax/benh/{disease}', [DiseaseController::class, 'ajaxXoa'])->name('ajax.benh.xoa');
    Route::delete('/ajax/benh-nhieu', [DiseaseController::class, 'ajaxXoaNhieu'])->name('ajax.benh.xoa-nhieu');
});
