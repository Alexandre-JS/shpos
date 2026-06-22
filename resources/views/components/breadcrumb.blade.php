@props([
    'items' => [],
])
<nav class="small text-muted" aria-label="Breadcrumb">
    <ol class="breadcrumb mb-0">
        @foreach ($items as $i => $item)
            @if (!empty($item['url']) && $i < count($items) - 1)
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="link-secondary text-decoration-none">{{ $item['label'] }}</a></li>
            @else
                <li class="breadcrumb-item active text-truncate" style="max-width:180px;" aria-current="page">{{ $item['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
