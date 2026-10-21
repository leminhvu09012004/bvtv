@props([
    'title' => null,
    'subtitle' => null,
    'headerAction' => null,
    'footer' => null,
    'padding' => true,
    'glass' => false,
])

@php
    $cardClasses = 'rounded-2xl transition-all duration-200 ' . 
        ($glass ? 'bg-white/80 backdrop-blur-md border border-white/60 shadow-sm' : 'bg-white border border-slate-200/90 shadow-2xs hover:shadow-xs');
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if($title || isset($header))
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-4">
            <div>
                @if(isset($header))
                    {{ $header }}
                @else
                    <h3 class="font-semibold text-slate-800 text-base leading-snug">{{ $title }}</h3>
                    @if($subtitle)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                    @endif
                @endif
            </div>
            @if($headerAction || isset($action))
                <div class="shrink-0">
                    {{ $headerAction ?? $action ?? '' }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-5' : '' }}">
        {{ $slot }}
    </div>

    @if($footer || isset($cardFooter))
        <div class="px-5 py-3.5 bg-slate-50/70 border-t border-slate-100 rounded-b-2xl">
            {{ $footer ?? $cardFooter ?? '' }}
        </div>
    @endif
</div>
