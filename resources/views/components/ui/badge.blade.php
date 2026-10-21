@props([
    'variant' => 'neutral',
    'size' => 'sm',
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full tracking-wide';

    $variants = [
        // Compatibility 4 states
        'forbidden' => 'bg-rose-50 text-rose-700 border border-rose-200/80 font-semibold',
        'avoid' => 'bg-amber-50 text-amber-800 border border-amber-200/80 font-medium',
        'compatible' => 'bg-emerald-50 text-emerald-800 border border-emerald-200/80 font-medium',
        'unknown' => 'bg-slate-100 text-slate-700 border border-slate-200 font-normal',

        // Generic states
        'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'danger' => 'bg-rose-50 text-rose-700 border border-rose-200',
        'info' => 'bg-sky-50 text-sky-700 border border-sky-200',
        'neutral' => 'bg-slate-100 text-slate-700 border border-slate-200',
        'brand' => 'bg-emerald-100 text-emerald-900 border border-emerald-300 font-semibold',
        'purple' => 'bg-purple-50 text-purple-700 border border-purple-200',
    ];

    $dotColors = [
        'forbidden' => 'bg-rose-500',
        'avoid' => 'bg-amber-500',
        'compatible' => 'bg-emerald-500',
        'unknown' => 'bg-slate-400',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
        'neutral' => 'bg-slate-400',
        'brand' => 'bg-emerald-600',
        'purple' => 'bg-purple-500',
    ];

    $sizes = [
        'xs' => 'text-[10px] px-2 py-0.5 gap-1',
        'sm' => 'text-xs px-2.5 py-0.5 gap-1.5',
        'md' => 'text-xs px-3 py-1 gap-1.5 font-semibold',
        'lg' => 'text-sm px-3.5 py-1.5 gap-2 font-semibold',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['neutral']) . ' ' . ($sizes[$size] ?? $sizes['sm']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $dotColors[$variant] ?? 'bg-slate-400' }}"></span>
    @endif
    {{ $slot }}
</span>
