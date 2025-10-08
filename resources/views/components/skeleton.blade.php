@props([
    'lines' => 3,
    'rounded' => 'md',
    'animate' => true,
])

@php
    $pulse = $animate ? 'animate-pulse' : '';
@endphp

<div {{ $attributes->merge(['class' => "space-y-2 $pulse"]) }}>
    @for ($i = 0; $i < $lines; $i++)
        <div
            class="h-3 bg-base-300/60 rounded-{{ $rounded }} w-{{ [
                '0' => 'full',
                '1' => '11/12',
                '2' => '10/12',
            ][$i % 3] ?? 'full' }}">
        </div>
    @endfor
</div>
