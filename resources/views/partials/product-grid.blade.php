@php $gridCols = $gridCols ?? 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5'; @endphp
<div class="grid {{ $gridCols }} gap-4">
    @forelse($items as $p)
        <x-product-card :product="$p" />
    @empty
        <div class="col-span-full">
            <x-empty icon="📦" title="Sem resultados"
                subtitle="Tente ajustar os filtros ou busca para encontrar produtos." />
        </div>
    @endforelse
</div>
