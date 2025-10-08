@props([
    'icon' => '🗂️',
    'title' => 'Nada encontrado',
    'subtitle' => null,
    'action' => null,
])

<div
    class="flex flex-col items-center justify-center text-center py-14 px-6 border border-dashed border-gray-300 rounded-lg bg-white/60">
    <div class="text-4xl mb-3 select-none">{{ $icon }}</div>
    <h3 class="font-medium text-base">{{ $title }}</h3>
    @if ($subtitle)
        <p class="mt-1 text-sm text-base-content/60 max-w-md">{{ $subtitle }}</p>
    @endif
    @if ($action)
        <div class="mt-4">{{ $action }}</div>
    @endif
</div>
