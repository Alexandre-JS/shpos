@props([
    'lines' => 3,
    'rounded' => 'md',
    'animate' => true,
])

@php
    $glow = $animate ? 'placeholder-glow' : '';
    $widths = ['col-12', 'col-11', 'col-10'];
@endphp

<div {{ $attributes->merge(['class' => "vstack gap-2 $glow"]) }}>
    @for ($i = 0; $i < $lines; $i++)
        <span class="placeholder rounded {{ $widths[$i % 3] }}" style="height:.75rem;"></span>
    @endfor
</div>
