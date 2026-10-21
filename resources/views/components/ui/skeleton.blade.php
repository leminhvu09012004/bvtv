@props([
    'type' => 'line', // line, card, avatar, table-row
    'lines' => 3,
])

@if($type === 'line')
    <div {{ $attributes->merge(['class' => 'animate-pulse bg-slate-200 rounded-md h-4 w-full']) }}></div>
@elseif($type === 'avatar')
    <div {{ $attributes->merge(['class' => 'animate-pulse bg-slate-200 rounded-full h-10 w-10 shrink-0']) }}></div>
@elseif($type === 'card')
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs animate-pulse">
        <div class="bg-slate-200 rounded-xl h-40 w-full mb-4"></div>
        <div class="h-4 bg-slate-200 rounded-md w-3/4 mb-2"></div>
        <div class="h-3 bg-slate-200 rounded-md w-1/2 mb-4"></div>
        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
            <div class="h-5 bg-slate-200 rounded-md w-24"></div>
            <div class="h-8 bg-slate-200 rounded-lg w-16"></div>
        </div>
    </div>
@elseif($type === 'table-row')
    <tr class="animate-pulse">
        @for($i = 0; $i < ($lines ?? 4); $i++)
            <td class="px-6 py-4">
                <div class="h-4 bg-slate-200 rounded-md w-full"></div>
            </td>
        @endfor
    </tr>
@endif
