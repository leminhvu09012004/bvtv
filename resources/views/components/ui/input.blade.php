@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'help' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
])

@php
    $inputId = $id ?? ($name ?? 'input-' . uniqid());
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);

    $inputClasses = 'w-full rounded-xl text-sm transition-all duration-150 py-2.5 ' .
        ($prefixIcon ? 'pl-10 ' : 'pl-3.5 ') .
        ($suffixIcon ? 'pr-10 ' : 'pr-3.5 ') .
        ($hasError 
            ? 'border-rose-300 bg-rose-50/30 text-rose-900 focus:border-rose-500 focus:ring-rose-500/20' 
            : 'border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-2xs') .
        ' border focus:outline-hidden focus:ring-3 disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed';
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $inputId }}" class="block text-xs font-semibold text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-xl">
        @if($prefixIcon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                {!! $prefixIcon !!}
            </div>
        @endif

        <input 
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        @if($suffixIcon)
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                {!! $suffixIcon !!}
            </div>
        @endif
    </div>

    @if($hasError)
        <p class="mt-1 text-xs text-rose-600 font-medium flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $errorMessage }}
        </p>
    @elseif($help)
        <p class="mt-1 text-xs text-slate-500">{{ $help }}</p>
    @endif
</div>
