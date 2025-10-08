@props(['product', 'showEntity' => false])

<?php
// Small helper formatting (kept in blade for quick iteration)
use Illuminate\Support\Str;
?>

<div
    class="group flex flex-col rounded-lg border border-base-200 bg-base-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
    <a href="{{ route('product.show', $product->slug) }}" class="aspect-[4/3] relative block overflow-hidden bg-base-200">
        @php
            $image = $product->primary_image_url ?? null;
        @endphp
        @if ($image)
            <img src="{{ $image }}" alt="{{ $product->name }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
        @else
            <div class="flex items-center justify-center h-full w-full text-base-content/40 text-sm">Sem imagem</div>
        @endif
        <div class="absolute top-2 left-2 flex gap-1">
            @if ($product->category)
                <span class="badge badge-neutral badge-xs">{{ $product->category->name }}</span>
            @endif
            @if ($product->is_featured ?? false)
                <span class="badge badge-primary badge-xs">Destaque</span>
            @endif
        </div>
    </a>

    <div class="flex flex-col flex-1 p-3">
        <h3 class="font-medium text-sm leading-tight line-clamp-2 min-h-[2.5rem]">
            <a href="{{ route('product.show', $product->slug) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        <p class="mt-2 text-xs text-base-content/70 line-clamp-2 min-h-[2.25rem]">
            {{ Str::limit(strip_tags($product->short_description ?? $product->description), 120) }}
        </p>

        @if ($showEntity && $product->entity)
            <div class="mt-2 flex items-center gap-2">
                <span
                    class="text-[11px] uppercase tracking-wide text-base-content/50">{{ $product->entity->name }}</span>
            </div>
        @endif

        <div class="mt-3 flex items-end justify-between">
            <div class="space-y-0.5">
                @if (!is_null($product->price))
                    <div class="font-semibold text-sm">
                        {{ number_format($product->price, 2, ',', '.') }} MT
                    </div>
                @endif
                @if ($product->views_count ?? false)
                    <div class="text-[10px] text-base-content/50">{{ $product->views_count }} visualizações</div>
                @endif
            </div>
            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-xs btn-primary">Ver</a>
        </div>
    </div>
</div>
