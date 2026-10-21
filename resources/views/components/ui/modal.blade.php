@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'size' => 'md',
    'actions' => null,
])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-6xl',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div 
    id="{{ $id }}"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="{{ $id }}-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Backdrop with blur -->
    <div 
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity duration-200"
        onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full {{ $sizeClass }} border border-slate-200">
            @if($title || isset($modalHeader))
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-base font-semibold leading-6 text-slate-800" id="{{ $id }}-title">
                        {{ $title ?? $modalHeader }}
                    </h3>
                    <button 
                        type="button" 
                        class="rounded-lg p-1 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                        onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                        aria-label="Đóng"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="px-6 py-5">
                {{ $slot }}
            </div>

            @if($actions || isset($modalActions))
                <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-100 flex flex-row-reverse gap-2 sm:justify-start">
                    {{ $actions ?? $modalActions }}
                </div>
            @endif
        </div>
    </div>
</div>
