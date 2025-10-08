@props([
    'items' => [], // [['label' => 'Home', 'url' => route('home')], ...]
])
<nav class="text-xs text-gray-500" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
        @foreach ($items as $i => $item)
            <li class="flex items-center gap-1">
                @if (!empty($item['url']) && $i < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="hover:text-gray-700 hover:underline">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-400">{{ $item['label'] }}</span>
                @endif
                @if ($i < count($items) - 1)
                    <span class="text-gray-400">›</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
