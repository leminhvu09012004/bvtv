@props(['pesticide'])

@php
    $variants = $pesticide->productVariants;
    $firstVariant = $variants->first();
    $minPrice = $variants->isNotEmpty() ? $variants->min('effective_price') : 0;
    $maxPrice = $variants->isNotEmpty() ? $variants->max('effective_price') : 0;
    $totalStock = $variants->isNotEmpty() ? $variants->flatMap->inventories->sum('quantity_available') : 0;
@endphp

<div {{ $attributes->merge(['class' => 'group bg-white rounded-2xl border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden h-full']) }}
     data-product-card="1"
     data-id="{{ $pesticide->id }}"
     data-category-id="{{ $pesticide->category_id }}"
     data-category-name="{{ mb_strtolower($pesticide->category->name ?? '') }}"
     data-form-type="{{ mb_strtolower($pesticide->form_type ?? '') }}"
     data-ingredient="{{ mb_strtolower($pesticide->active_ingredient ?? '') }}"
     data-in-stock="{{ $totalStock > 0 ? '1' : '0' }}"
     data-price="{{ (int)$minPrice }}">

    <!-- 1. PRODUCT IMAGE (UNIFORM 1:1 SQUARE ASPECT RATIO) -->
    <div class="relative aspect-square w-full bg-slate-50/80 p-3 sm:p-4 flex items-center justify-center overflow-hidden border-b border-slate-100">
        @if($pesticide->image_url)
            <img src="{{ $pesticide->image_url }}"
                 alt="{{ $pesticide->name }}"
                 loading="lazy"
                 class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300 drop-shadow-xs">
        @else
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl">
                💊
            </div>
        @endif

        <!-- Category Badge on Top-Left -->
        @if($pesticide->category)
            <div class="absolute top-2.5 left-2.5 pointer-events-none">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-white/95 backdrop-blur-xs rounded-full shadow-2xs border border-emerald-100">
                    {{ $pesticide->category->emoji ?? '🌿' }} {{ $pesticide->category->name }}
                </span>
            </div>
        @endif

        <!-- FRAC/IRAC Badge on Top-Right -->
        @if($pesticide->frac_code || $pesticide->irac_code)
            <div class="absolute top-2.5 right-2.5 pointer-events-none">
                <span class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-black text-purple-800 bg-purple-50/90 rounded-md border border-purple-200">
                    {{ $pesticide->frac_code ?: $pesticide->irac_code }}
                </span>
            </div>
        @endif
    </div>

    <!-- 2. PRODUCT DETAILS & SPECS -->
    <div class="p-3.5 sm:p-4 flex-1 flex flex-col justify-between space-y-3">
        <div>
            <!-- Name -->
            <a href="{{ route('thuoc.xem', $pesticide) }}"
               class="font-bold text-slate-900 text-sm sm:text-base leading-snug hover:text-emerald-700 transition line-clamp-2 block"
               title="{{ $pesticide->name }}">
                {{ $pesticide->name }}
            </a>

            <!-- Active Ingredient -->
            @if($pesticide->active_ingredient)
                <div class="mt-1 text-xs text-slate-600 flex items-center gap-1.5">
                    <span class="text-emerald-600 shrink-0">⚗️</span>
                    <span class="truncate text-[11px]" title="{{ $pesticide->active_ingredient }}">
                        {{ $pesticide->active_ingredient }}
                    </span>
                </div>
            @endif

            <!-- Packaging / Specification -->
            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-slate-500">
                <span class="shrink-0 text-slate-400">📦</span>
                <span class="truncate text-[11px] font-medium text-slate-700">
                    {{ $firstVariant?->specification ?? ($pesticide->concentration ?: 'Chai/Gói tiêu chuẩn') }}
                </span>
            </div>
        </div>

        <!-- 3. PRICE, STOCK & ACTIONS -->
        <div class="pt-2.5 border-t border-slate-100 space-y-2.5">
            <div class="flex items-baseline justify-between gap-1">
                <!-- Price -->
                <div>
                    @if($minPrice > 0)
                        <div class="text-base sm:text-lg font-black text-emerald-600 tracking-tight">
                            {{ number_format($minPrice, 0, ',', '.') }} ₫
                        </div>
                        @if($minPrice != $maxPrice)
                            <div class="text-[10px] text-slate-400">
                                ~ {{ number_format($maxPrice, 0, ',', '.') }} ₫
                            </div>
                        @endif
                    @else
                        <div class="text-sm font-bold text-slate-500">
                            Liên hệ báo giá
                        </div>
                    @endif
                </div>

                <!-- Stock Badge -->
                <div>
                    @if($totalStock > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            ✓ Còn {{ $totalStock }} sp
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                            Tạm hết hàng
                        </span>
                    @endif
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex items-center gap-1.5 pt-1">
                @if($firstVariant && $totalStock > 0)
                    <button type="button"
                            onclick="quickAddToCart({{ $firstVariant->id }}, '{{ addslashes($pesticide->name) }}')"
                            class="flex-1 py-2 px-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs transition border border-emerald-300 flex items-center justify-center gap-1 shadow-2xs cursor-pointer">
                        <span>🛒</span>
                        <span class="hidden sm:inline">Thêm giỏ</span>
                    </button>
                @endif

                <a href="{{ route('thuoc.xem', $pesticide) }}"
                   class="flex-1 py-2 px-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition text-center flex items-center justify-center gap-1 shadow-2xs">
                    <span>Chi tiết</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>

</div>
