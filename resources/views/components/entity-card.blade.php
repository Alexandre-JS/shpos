@props(['entity'])
<a href="{{ route('entity.show', $entity->slug) }}"
    class="border bg-white rounded p-4 flex flex-col gap-2 hover:shadow-sm transition">
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-sm line-clamp-1">{{ $entity->name }}</h3>
        @if ($entity->is_featured)
            <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">Destaque</span>
        @endif
    </div>
    <p class="text-xs text-gray-500 line-clamp-3">{{ $entity->description }}</p>
    <div class="mt-auto text-[10px] text-gray-400 flex gap-3">
        <span>{{ $entity->location_city }}</span>
        <span>•</span>
        <span>{{ $entity->products()->count() }} itens</span>
    </div>
</a>
