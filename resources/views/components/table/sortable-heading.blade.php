@props(['sort'])

<th {{ $attributes->merge(['class' => 'border cursor-pointer']) }}>
    <div class="flex items-center gap-1">
        <div class="">{{ $slot }}</div>
        <div class="">
            @if ($sort != '' && $sort == 'desc')
                <x-icons.arrow-narrow-up class="w-4 h-4 stroke-[3]" />
            @endif

            @if ($sort != '' && $sort == 'asc')
                <x-icons.arrow-narrow-down class="w-4 h-4 stroke-[3]" />
            @endif
        </div>
    </div>
</th>
