@php $gridCols = $gridCols ?? 'row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5'; @endphp
<div class="row {{ $gridCols }} g-3">
    @forelse($items as $p)
        <div class="col"><x-product-card :product="$p" /></div>
    @empty
        <div class="col-12">
            <x-empty icon="📦" title="Sem resultados"
                subtitle="Tente ajustar os filtros ou busca para encontrar produtos." />
        </div>
    @endforelse
</div>
