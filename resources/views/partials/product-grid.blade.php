<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
    @forelse($items as $p)
        <x-product-card :product="$p" />
    @empty
        <div class="col-span-full">
            <x-empty icon="📦" title="Sem resultados"
                subtitle="Tente ajustar os filtros ou busca para encontrar produtos." />
        </div>
    @endforelse
</div>
