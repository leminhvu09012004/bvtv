@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-hidden focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed select-none cursor-pointer';

    $variants = [
        'primary' => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white shadow-xs hover:shadow-sm focus:ring-emerald-500 border border-emerald-600',
        'secondary' => 'bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 border border-slate-300 shadow-2xs focus:ring-emerald-500',
        'success' => 'bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white shadow-xs focus:ring-teal-500 border border-teal-600',
        'danger' => 'bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white shadow-xs focus:ring-rose-500 border border-rose-600',
        'warning' => 'bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white shadow-xs focus:ring-amber-500 border border-amber-500',
        'dark' => 'bg-slate-900 hover:bg-slate-800 active:bg-black text-white shadow-xs focus:ring-slate-700 border border-slate-900',
        'outline' => 'bg-transparent hover:bg-emerald-50 text-emerald-700 border border-emerald-600 focus:ring-emerald-500',
        'ghost' => 'bg-transparent hover:bg-slate-100 active:bg-slate-200 text-slate-700 border border-transparent focus:ring-slate-400',
    ];

    $sizes = [
        'xs' => 'text-xs px-2.5 py-1 rounded-lg gap-1.5',
        'sm' => 'text-xs px-3 py-1.5 rounded-lg gap-1.5 font-medium',
        'md' => 'text-sm px-4 py-2 rounded-xl gap-2 font-medium',
        'lg' => 'text-base px-5 py-2.5 rounded-xl gap-2.5 font-semibold',
        'xl' => 'text-lg px-6 py-3.5 rounded-2xl gap-3 font-semibold',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </button>
@endif
