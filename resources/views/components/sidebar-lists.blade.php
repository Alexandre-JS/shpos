@props(['categories' => collect(), 'entities' => collect()])

<aside class="space-y-8 text-sm">
    <div>
        <h3 class="font-semibold text-xs uppercase tracking-wide text-gray-500 mb-2">Categorias</h3>
        <ul class="divide-y divide-gray-100 border rounded bg-white overflow-hidden">
            @forelse($categories as $cat)
                <li>
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="flex items-center justify-between px-3 py-2 hover:bg-gray-50">
                        <span class="truncate">{{ $cat->name }}</span>
                        <span
                            class="ml-2 inline-flex items-center justify-center text-[10px] min-w-[1.5rem] h-5 rounded bg-gray-100 text-gray-700">{{ $cat->items_count }}</span>
                    </a>
                </li>
            @empty
                <li class="px-3 py-2 text-gray-400">Sem categorias</li>
            @endforelse
        </ul>
    </div>
    <div>
        <h3 class="font-semibold text-xs uppercase tracking-wide text-gray-500 mb-2">Entidades</h3>
        <ul class="divide-y divide-gray-100 border rounded bg-white overflow-hidden">
            @forelse($entities as $e)
                <li>
                    <a href="{{ route('entity.show', $e->slug) }}"
                        class="flex items-center justify-between px-3 py-2 hover:bg-gray-50">
                        <span class="truncate">{{ $e->name }}</span>
                        <span
                            class="ml-2 inline-flex items-center justify-center text-[10px] min-w-[1.5rem] h-5 rounded bg-gray-100 text-gray-700">{{ $e->items_count }}</span>
                    </a>
                </li>
            @empty
                <li class="px-3 py-2 text-gray-400">Sem entidades</li>
            @endforelse
        </ul>
        @if ($entities instanceof \Illuminate\Support\Collection && $entities->count() === 30)
            <p class="mt-2 text-[10px] text-gray-400">
                Mostrando top 30. <a href="{{ route('entities.index') }}" class="underline hover:text-primary">Ver todas
                    »</a>
            </p>
        @else
            <p class="mt-2 text-[10px] text-gray-400">Ordenado por itens.</p>
        @endif
    </div>
</aside>
