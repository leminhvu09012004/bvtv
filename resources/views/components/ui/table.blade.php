@props([
    'headers' => [],
    'striped' => false,
    'hoverable' => true,
    'compact' => false,
])

<div class="overflow-x-auto rounded-2xl border border-slate-200/90 bg-white shadow-2xs">
    <table {{ $attributes->merge(['class' => 'w-full text-left text-sm text-slate-600']) }}>
        @if(!empty($headers) || isset($tableHeader))
            <thead class="bg-slate-50/90 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200 tracking-wider">
                @if(isset($tableHeader))
                    {{ $tableHeader }}
                @else
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="{{ $compact ? 'px-4 py-2.5' : 'px-6 py-3.5' }}">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                @endif
            </thead>
        @endif
        <tbody class="divide-y divide-slate-100 font-normal">
            {{ $slot }}
        </tbody>
    </table>
</div>
