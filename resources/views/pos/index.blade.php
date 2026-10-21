<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Bán Hàng Nhanh — BVTV Tây Nguyên</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-100/90 text-slate-800 font-sans select-none overflow-hidden" x-data="posApp()">

    <!-- Top POS Navigation Bar (Sáng & Hiện Đại) -->
    <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between z-30 shadow-2xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-emerald-700 font-black text-base hover:text-emerald-800 transition">
                <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg shadow-2xs">🌿</span>
                <span class="tracking-tight text-base sm:text-lg text-emerald-700 font-black">BVTV POS</span>
            </a>
            <span class="text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-bold">
                Live v2.6
            </span>
            <div class="h-5 w-px bg-slate-200 mx-1"></div>
            <!-- Warehouse Switcher -->
            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-500 font-medium hidden sm:inline">Kho:</span>
                <select 
                    x-model="selectedWarehouseId" 
                    @change="switchWarehouse()"
                    class="bg-slate-50 text-slate-800 text-xs rounded-xl px-2.5 py-1.5 border border-slate-200 focus:outline-hidden focus:border-emerald-500 font-bold shadow-2xs cursor-pointer hover:bg-slate-100 transition"
                >
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}" {{ $selectedWarehouse->id === $wh->id ? 'selected' : '' }}>
                            {{ $wh->name }} ({{ $wh->code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Hotkeys Indicator -->
        <div class="hidden md:flex items-center gap-2 text-xs text-slate-500">
            <span class="flex items-center gap-1.5 bg-slate-50 px-2.5 py-1 rounded-xl border border-slate-200 font-medium shadow-2xs">
                <kbd class="font-mono text-[10px] font-bold bg-white text-slate-700 px-1.5 py-0.5 rounded border border-slate-300 shadow-2xs">F2</kbd> Tìm kiếm
            </span>
            <span class="flex items-center gap-1.5 bg-slate-50 px-2.5 py-1 rounded-xl border border-slate-200 font-medium shadow-2xs">
                <kbd class="font-mono text-[10px] font-bold bg-white text-slate-700 px-1.5 py-0.5 rounded border border-slate-300 shadow-2xs">F4</kbd> Giảm giá
            </span>
            <span class="flex items-center gap-1.5 bg-slate-50 px-2.5 py-1 rounded-xl border border-slate-200 font-medium shadow-2xs">
                <kbd class="font-mono text-[10px] font-bold bg-white text-slate-700 px-1.5 py-0.5 rounded border border-slate-300 shadow-2xs">F6</kbd> Tiền khách
            </span>
            <span class="flex items-center gap-1.5 bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-xl border border-emerald-200 font-bold shadow-2xs">
                <kbd class="font-mono text-[10px] bg-emerald-700 text-white px-1.5 py-0.5 rounded shadow-2xs">F12</kbd> Thanh toán
            </span>
        </div>

        <!-- User / Exit & Switcher -->
        <div class="flex items-center gap-2 sm:gap-2.5 text-xs">
            <span class="text-slate-500 font-medium hidden lg:inline">Thu ngân: <strong class="text-slate-800 font-bold">{{ auth()->check() ? auth()->user()->name : 'pos@bvtvtaynguyen.vn' }}</strong></span>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.inventory.index') }}" class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold transition flex items-center gap-1 shadow-2xs">
                    <span>🏢</span> Về Quản Trị
                </a>
                <a href="{{ route('phoi-tron.index') }}" class="px-2.5 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 font-bold transition flex items-center gap-1 shadow-2xs">
                    <span>🔬</span> Sang Kỹ Sư
                </a>
            @endif
            <a href="{{ route('home') }}" class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 font-semibold transition shadow-2xs">
                Thoát POS
            </a>
        </div>
    </header>

    <!-- Main POS Workspace: 62% Left Product Catalog, 38% Right Register Cart -->
    <main class="h-[calc(100vh-4rem)] flex overflow-hidden">

        <!-- LEFT COLUMN (62%): Product Search & Grid (Giao diện sáng, Thẻ to, Có ảnh) -->
        <section class="w-[62%] h-full flex flex-col border-r border-slate-200 bg-slate-100/70">
            <!-- Search Bar & Barcode Input & Category Filters -->
            <div class="p-3.5 bg-white border-b border-slate-200 flex items-center gap-3 shadow-2xs">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        x-ref="searchInput"
                        x-model="searchQuery"
                        @keydown.enter="handleEnterSearch()"
                        placeholder="Quét mã vạch, SKU hoặc gõ tên sản phẩm, hoạt chất... (F2)" 
                        class="w-full bg-slate-50 text-slate-900 pl-10 pr-24 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 placeholder-slate-400 font-medium transition"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-[10px] font-mono font-bold bg-white text-slate-500 px-2 py-0.5 rounded-md border border-slate-200 shadow-2xs">F2</span>
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="flex items-center gap-1.5 overflow-x-auto max-w-sm scrollbar-none py-1">
                    <button 
                        @click="selectedCategory = 'ALL'"
                        :class="selectedCategory === 'ALL' ? 'bg-emerald-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200/80'"
                        class="px-3 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer"
                    >
                        🌾 Tất cả
                    </button>
                    <template x-for="cat in categories" :key="cat">
                        <button 
                            @click="selectedCategory = cat"
                            :class="selectedCategory === cat ? 'bg-emerald-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200/80'"
                            class="px-3 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer font-medium"
                            x-text="cat"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Product Cards Grid (Thẻ Lớn Hơn, Có Ảnh, Ẩn Mã SKU) -->
            <div class="flex-1 overflow-y-auto p-4 grid grid-cols-2 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-3.5 sm:gap-4 content-start">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div 
                        @click="addToCart(product)"
                        :class="product.stock <= 0 ? 'opacity-60 cursor-not-allowed bg-slate-50' : 'hover:border-emerald-500 hover:shadow-lg cursor-pointer bg-white active:scale-[0.99]'"
                        class="border border-slate-200 rounded-2xl flex flex-col justify-between transition-all duration-200 group relative overflow-hidden shadow-2xs"
                    >
                        <!-- 1. HÌNH ẢNH SẢN PHẨM RÕ NÉT (THAY VÌ ĐEN TỐI KHÔNG CÓ ẢNH) -->
                        <div class="relative h-28 sm:h-32 w-full bg-slate-50 p-2.5 flex items-center justify-center overflow-hidden border-b border-slate-100">
                            <template x-if="product.image">
                                <img :src="product.image" :alt="product.name" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300 drop-shadow-2xs">
                            </template>
                            <template x-if="!product.image">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shadow-2xs">
                                    <span x-text="product.category_emoji || '🌿'"></span>
                                </div>
                            </template>

                            <!-- Tồn kho badge ở góc trên phải của ảnh -->
                            <div class="absolute top-2 right-2">
                                <span 
                                    :class="product.stock > 10 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : (product.stock > 0 ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200 font-bold')"
                                    class="text-[10px] font-bold px-2 py-0.5 rounded-full border shadow-2xs backdrop-blur-xs"
                                    x-text="product.stock > 0 ? ('Tồn: ' + product.stock) : 'Hết hàng'"
                                ></span>
                            </div>

                            <!-- Quy cách badge ở góc trên trái -->
                            <div class="absolute top-2 left-2" x-show="product.variant_name && product.variant_name !== 'Tiêu chuẩn'">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/95 text-slate-700 border border-slate-200 shadow-2xs backdrop-blur-xs truncate max-w-[110px]" x-text="product.variant_name"></span>
                            </div>
                        </div>

                        <!-- 2. THÔNG TIN SẢN PHẨM (KHÔNG HIỆN MÃ SKU RỐI MẮT) -->
                        <div class="p-3 flex flex-col justify-between flex-1">
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-2 leading-snug group-hover:text-emerald-700 transition" x-text="product.pesticide_name || product.name"></h4>
                                <p class="text-[11px] text-slate-400 mt-1 truncate" x-text="product.active_ingredient || product.category"></p>
                            </div>

                            <!-- Giá bán & Nút Chọn -->
                            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-sm sm:text-base font-black text-emerald-700 tabular-nums" x-text="formatMoney(product.price)"></span>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 group-hover:bg-emerald-600 group-hover:text-white px-2.5 py-1 rounded-xl transition shadow-2xs">
                                    + Thêm
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- RIGHT COLUMN (38%): Cashier Register & Cart (Nền trắng, Sáng sủa, Độ tương phản cao) -->
        <section class="w-[38%] h-full flex flex-col bg-white border-l border-slate-200 shadow-sm">

            <!-- Customer & Invoice Header -->
            <div class="p-3.5 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between gap-2.5">
                <div class="flex-1">
                    <input 
                        type="text" 
                        x-model="customerName"
                        placeholder="Tên khách hàng (Mặc định: Khách lẻ)"
                        class="w-full bg-white text-xs text-slate-900 px-3 py-2 rounded-xl border border-slate-200 focus:outline-hidden focus:border-emerald-500 placeholder-slate-400 shadow-2xs font-medium"
                    />
                </div>
                <div class="w-32">
                    <input 
                        type="text" 
                        x-model="customerPhone"
                        placeholder="Số ĐT"
                        class="w-full bg-white text-xs text-slate-900 px-3 py-2 rounded-xl border border-slate-200 focus:outline-hidden focus:border-emerald-500 placeholder-slate-400 font-mono shadow-2xs"
                    />
                </div>
                <button 
                    @click="clearCart()" 
                    title="Xóa toàn bộ giỏ"
                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items List Table -->
            <div class="flex-1 overflow-y-auto divide-y divide-slate-100 px-4">
                <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-slate-400 py-16">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-3xl mb-3">🛒</div>
                    <p class="text-sm font-bold text-slate-700">Giỏ hàng đang trống</p>
                    <p class="text-xs text-slate-400 mt-1">Chọn sản phẩm bên trái hoặc quét mã vạch</p>
                </div>

                <template x-for="(item, index) in cart" :key="item.variant_id">
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs font-bold text-slate-800 truncate" x-text="item.name"></span>
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-2">
                                <span class="tabular-nums" x-text="formatMoney(item.price)"></span>
                                <span class="text-slate-400">×</span>
                                <span class="font-bold text-emerald-700" x-text="item.quantity"></span>
                            </div>
                        </div>

                        <!-- Quantity control -->
                        <div class="flex items-center gap-1 bg-slate-100 border border-slate-200 rounded-xl p-0.5 shadow-2xs">
                            <button 
                                @click="decreaseQty(index)"
                                class="w-6 h-6 flex items-center justify-center text-slate-600 hover:text-slate-900 rounded-lg hover:bg-white font-bold transition cursor-pointer"
                            >-</button>
                            <span class="w-7 text-center text-xs font-bold tabular-nums text-slate-800" x-text="item.quantity"></span>
                            <button 
                                @click="increaseQty(index)"
                                class="w-6 h-6 flex items-center justify-center text-slate-600 hover:text-slate-900 rounded-lg hover:bg-white font-bold transition cursor-pointer"
                            >+</button>
                        </div>

                        <!-- Item Total & Remove -->
                        <div class="text-right w-24">
                            <div class="text-xs font-black text-slate-900 tabular-nums" x-text="formatMoney(item.price * item.quantity)"></div>
                            <button 
                                @click="removeItem(index)" 
                                class="text-[11px] text-rose-500 hover:text-rose-700 hover:underline transition cursor-pointer mt-0.5"
                            >Xóa</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Tank-Mix Pre-Checkout Safety Alert Banner -->
            <div x-show="cart.length > 0 && mixingAlert" x-cloak style="display: none;" class="mx-4 my-2.5 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs flex items-start gap-2 shadow-2xs">
                <span class="text-base">⚠️</span>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-[11px] text-rose-800 uppercase tracking-wide">CẢNH BÁO TƯƠNG KỴ TRONG ĐƠN HÀNG</p>
                    <p class="text-[11px] text-rose-700 mt-0.5 font-medium" x-text="mixingAlert"></p>
                </div>
            </div>

            <!-- Payment Calculation & Action Panel -->
            <div class="p-4 bg-slate-50/90 border-t border-slate-200 space-y-3">
                <!-- Subtotal / Discount / Total -->
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between text-slate-600 font-medium">
                        <span>Tạm tính (<span x-text="cartItemCount" class="font-bold"></span> món):</span>
                        <span class="tabular-nums font-bold text-slate-800" x-text="formatMoney(subtotal)"></span>
                    </div>

                    <!-- Discount Row (F4) -->
                    <div class="flex items-center justify-between text-slate-600">
                        <div class="flex items-center gap-1.5 font-medium">
                            <span>Chiết khấu:</span>
                            <span class="text-[9px] font-mono font-bold bg-white text-slate-500 px-1.5 py-0.5 rounded border border-slate-200 shadow-2xs">F4</span>
                        </div>
                        <div class="w-32">
                            <input 
                                type="number" 
                                x-ref="discountInput"
                                x-model.number="discount" 
                                placeholder="0" 
                                class="w-full bg-white text-right text-xs text-slate-900 px-2.5 py-1 rounded-xl border border-slate-200 focus:outline-hidden focus:border-emerald-500 font-mono font-bold shadow-2xs"
                            />
                        </div>
                    </div>

                    <div class="pt-2.5 border-t border-slate-200 flex justify-between items-baseline">
                        <span class="text-xs sm:text-sm font-extrabold text-slate-900">TỔNG THANH TOÁN:</span>
                        <span class="text-xl sm:text-2xl font-black text-emerald-700 tabular-nums" x-text="formatMoney(total)"></span>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <button 
                        @click="paymentMethod = 'CASH'"
                        :class="paymentMethod === 'CASH' ? 'bg-emerald-600 text-white font-bold border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                        class="py-2 rounded-xl border text-center transition cursor-pointer shadow-2xs"
                    >💵 Tiền mặt</button>
                    <button 
                        @click="paymentMethod = 'BANK_TRANSFER'"
                        :class="paymentMethod === 'BANK_TRANSFER' ? 'bg-emerald-600 text-white font-bold border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                        class="py-2 rounded-xl border text-center transition cursor-pointer shadow-2xs"
                    >🏦 Chuyển khoản</button>
                    <button 
                        @click="paymentMethod = 'QR'"
                        :class="paymentMethod === 'QR' ? 'bg-emerald-600 text-white font-bold border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                        class="py-2 rounded-xl border text-center transition cursor-pointer shadow-2xs"
                    >📱 Quét QR</button>
                </div>

                <!-- Cash Tendered & Change (F6) -->
                <div x-show="paymentMethod === 'CASH'" class="flex items-center justify-between text-xs pt-1">
                    <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                        <span>Khách đưa:</span>
                        <span class="text-[9px] font-mono font-bold bg-white text-slate-500 px-1.5 py-0.5 rounded border border-slate-200 shadow-2xs">F6</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <input 
                            type="number" 
                            x-ref="cashTenderedInput"
                            x-model.number="cashTendered"
                            class="w-32 bg-white text-right text-xs text-slate-900 px-2.5 py-1.5 rounded-xl border border-slate-200 focus:outline-hidden focus:border-emerald-500 font-mono font-bold shadow-2xs"
                        />
                        <div class="text-xs text-slate-600 font-medium">
                            Thối: <span class="font-bold text-amber-600 tabular-nums" x-text="formatMoney(changeAmount)"></span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button (F12) -->
                <button 
                    @click="submitCheckout()"
                    :disabled="cart.length === 0 || isSubmitting"
                    class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-black text-sm rounded-2xl transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg cursor-pointer"
                >
                    <template x-if="isSubmitting">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="isSubmitting ? 'ĐANG XỬ LÝ...' : 'THANH TOÁN & IN HÓA ĐƠN (F12)'">THANH TOÁN & IN HÓA ĐƠN (F12)</span>
                </button>
            </div>
        </section>
    </main>

    <!-- HIDDEN THERMAL 80mm RECEIPT PRINT TEMPLATE -->
    <div id="printable-receipt" class="hidden">
        <div style="text-align: center; margin-bottom: 8px;">
            <h2 style="font-size: 14px; font-weight: bold; margin: 0;">CỬA HÀNG BVTV TÂY NGUYÊN</h2>
            <p style="font-size: 10px; margin: 2px 0;">Đ/c: TT. Phước An, Krông Pắk, Đắk Lắk</p>
            <p style="font-size: 10px; margin: 2px 0;">Hotline: 0984.123.456</p>
            <h3 style="font-size: 12px; margin: 6px 0; text-transform: uppercase;">PHIẾU THANH TOÁN</h3>
        </div>
        <div style="font-size: 10px; margin-bottom: 6px;">
            <div>Mã đơn: <b x-text="lastCompletedOrder?.order_number"></b></div>
            <div>Ngày: <span x-text="lastCompletedOrder?.created_at"></span></div>
            <div>Khách hàng: <span x-text="lastCompletedOrder?.customer_name"></span></div>
        </div>
        <hr style="border: none; border-top: 1px dashed #000; margin: 4px 0;" />
        <table style="width: 100%; font-size: 10px; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left;">
                    <th style="padding: 2px 0;">Tên thuốc</th>
                    <th style="padding: 2px 0; text-align: center;">SL</th>
                    <th style="padding: 2px 0; text-align: right;">Đ.Giá</th>
                    <th style="padding: 2px 0; text-align: right;">T.Tiền</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in lastCompletedOrder?.items" :key="item.sku">
                    <tr>
                        <td style="padding: 2px 0;" x-text="item.name"></td>
                        <td style="padding: 2px 0; text-align: center;" x-text="item.quantity"></td>
                        <td style="padding: 2px 0; text-align: right;" x-text="formatMoney(item.unit_price)"></td>
                        <td style="padding: 2px 0; text-align: right;" x-text="formatMoney(item.total_price)"></td>
                    </tr>
                </template>
            </tbody>
        </table>
        <hr style="border: none; border-top: 1px dashed #000; margin: 4px 0;" />
        <div style="font-size: 11px; text-align: right;">
            <div>Tổng tiền: <b x-text="formatMoney(lastCompletedOrder?.total_amount)"></b></div>
            <div style="font-size: 9px; text-align: center; margin-top: 10px;">
                Cảm ơn Quý khách & Hẹn gặp lại!<br/>
                Kính chúc Quý bà con vụ mùa bội thu!
            </div>
        </div>
    </div>

    <!-- POS Alpine Component Script -->
    <script>
        function posApp() {
            return {
                selectedWarehouseId: {{ $selectedWarehouse->id }},
                products: @json($variants),
                searchQuery: '',
                selectedCategory: 'ALL',
                cart: [],
                customerName: '',
                customerPhone: '',
                discount: 0,
                paymentMethod: 'CASH',
                cashTendered: 0,
                isSubmitting: false,
                lastCompletedOrder: null,
                mixingAlert: null,

                init() {
                    // Lắng nghe các phím tắt F2, F4, F6, F12
                    window.addEventListener('keydown', (e) => {
                        if (e.key === 'F2') {
                            e.preventDefault();
                            this.$refs.searchInput.focus();
                        } else if (e.key === 'F4') {
                            e.preventDefault();
                            this.$refs.discountInput.focus();
                        } else if (e.key === 'F6') {
                            e.preventDefault();
                            this.$refs.cashTenderedInput.focus();
                        } else if (e.key === 'F12') {
                            e.preventDefault();
                            if (this.cart.length > 0 && !this.isSubmitting) {
                                this.submitCheckout();
                            }
                        }
                    });

                    this.$nextTick(() => {
                        this.$refs.searchInput?.focus();
                    });
                },

                get categories() {
                    const cats = new Set(this.products.map(p => p.category).filter(Boolean));
                    return Array.from(cats);
                },

                get filteredProducts() {
                    let list = this.products;
                    if (this.selectedCategory !== 'ALL') {
                        list = list.filter(p => p.category === this.selectedCategory);
                    }
                    if (this.searchQuery.trim() !== '') {
                        const q = this.searchQuery.toLowerCase().trim();
                        list = list.filter(p => 
                            p.name.toLowerCase().includes(q) ||
                            (p.sku && p.sku.toLowerCase().includes(q)) ||
                            (p.barcode && p.barcode.toLowerCase().includes(q)) ||
                            (p.active_ingredient && p.active_ingredient.toLowerCase().includes(q))
                        );
                    }
                    return list;
                },

                get cartItemCount() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get total() {
                    return Math.max(0, this.subtotal - (this.discount || 0));
                },

                get changeAmount() {
                    if (this.paymentMethod !== 'CASH') return 0;
                    return Math.max(0, (this.cashTendered || 0) - this.total);
                },

                switchWarehouse() {
                    window.location.href = `{{ route('pos.index') }}?warehouse_id=${this.selectedWarehouseId}`;
                },

                addToCart(product) {
                    if (product.stock <= 0) {
                        alert(`Sản phẩm ${product.name} đã hết hàng tại kho này!`);
                        return;
                    }
                    const existing = this.cart.find(i => i.variant_id === product.id);
                    if (existing) {
                        if (existing.quantity >= product.stock) {
                            alert(`Số lượng tồn khả dụng chỉ còn ${product.stock}`);
                            return;
                        }
                        existing.quantity++;
                    } else {
                        this.cart.push({
                            variant_id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            max_stock: product.stock,
                            active_ingredient: product.active_ingredient,
                        });
                    }
                    this.checkTankMixCompatibility();
                },

                increaseQty(index) {
                    const item = this.cart[index];
                    if (item.quantity >= item.max_stock) {
                        alert(`Chỉ còn ${item.max_stock} sản phẩm trong kho!`);
                        return;
                    }
                    item.quantity++;
                },

                decreaseQty(index) {
                    const item = this.cart[index];
                    if (item.quantity > 1) {
                        item.quantity--;
                    } else {
                        this.cart.splice(index, 1);
                    }
                    this.checkTankMixCompatibility();
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                    this.checkTankMixCompatibility();
                },

                clearCart() {
                    if (confirm('Bạn có chắc muốn xóa giỏ hàng hiện tại?')) {
                        this.cart = [];
                        this.discount = 0;
                        this.cashTendered = 0;
                        this.mixingAlert = null;
                    }
                },

                handleEnterSearch() {
                    const matched = this.filteredProducts;
                    if (matched.length === 1) {
                        this.addToCart(matched[0]);
                        this.searchQuery = '';
                    }
                },

                checkTankMixCompatibility() {
                    this.mixingAlert = null;
                    if (this.cart.length < 2) return;

                    const ingredients = this.cart.map(i => (i.active_ingredient || '').toLowerCase()).join(' ');
                    if ((ingredients.includes('copper') || ingredients.includes('đồng')) && 
                        (ingredients.includes('mineral oil') || ingredients.includes('dầu khoáng'))) {
                        this.mixingAlert = 'Phát hiện Thuốc gốc Đồng và Dầu khoáng trong đơn hàng! Nhắc khách hàng không pha chung vào cùng phuy phun.';
                    } else if ((ingredients.includes('mineral oil') || ingredients.includes('dầu khoáng')) && 
                        (ingredients.includes('sulfur') || ingredients.includes('lưu huỳnh'))) {
                        this.mixingAlert = 'Phát hiện Dầu khoáng và Lưu huỳnh! Cấm pha chung hoặc phun gần ngày nhau.';
                    } else if ((ingredients.includes('copper') || ingredients.includes('đồng')) && 
                        (ingredients.includes('trichoderma') || ingredients.includes('bacillus'))) {
                        this.mixingAlert = 'Phát hiện Gốc Đồng và Chế phẩm Vi sinh! Đồng sẽ tiêu diệt bào tử nấm đối kháng.';
                    }
                },

                async submitCheckout() {
                    if (this.cart.length === 0) return;
                    this.isSubmitting = true;

                    try {
                        const payload = {
                            warehouse_id: this.selectedWarehouseId,
                            items: this.cart.map(i => ({
                                variant_id: i.variant_id,
                                quantity: i.quantity,
                            })),
                            customer_name: this.customerName || 'Khách lẻ tại quầy',
                            customer_phone: this.customerPhone || '0900000000',
                            discount_amount: this.discount || 0,
                            payment_method: this.paymentMethod,
                            cash_tendered: this.cashTendered || 0,
                            idempotency_key: 'POS-' + Date.now() + '-' + Math.random().toString(36).substring(2, 7),
                        };

                        const response = await fetch('{{ route("pos.checkout") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(payload),
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            alert('Thanh toán thất bại: ' + (data.message || 'Lỗi server'));
                            this.isSubmitting = false;
                            return;
                        }

                        this.lastCompletedOrder = data.order;
                        alert(`Thanh toán thành công đơn hàng #${data.order.order_number}!`);

                        // In hóa đơn 80mm
                        this.$nextTick(() => {
                            window.print();
                        });

                        // Reset giỏ hàng
                        this.cart = [];
                        this.discount = 0;
                        this.cashTendered = 0;
                        this.mixingAlert = null;
                        this.customerName = '';
                        this.customerPhone = '';
                        this.$refs.searchInput?.focus();

                    } catch (e) {
                        alert('Lỗi kết nối khi thanh toán: ' + e.message);
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                formatMoney(amount) {
                    if (!amount) return '0 ₫';
                    return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
                }
            };
        }
    </script>
</body>
</html>
