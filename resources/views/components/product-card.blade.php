@props(['product', 'showEntity' => false])

<?php
use Illuminate\Support\Str;
?>

<div
    class="group flex flex-col rounded-lg border border-gray-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
    <a href="{{ route('product.show', $product->slug) }}" class="aspect-[4/3] relative block overflow-hidden bg-gray-100">
        @php
            $primary = method_exists($product, 'primaryImage') ? $product->primaryImage() : null;
            $orig = $primary?->path ?? $product->image_path;
            $display = null;
            if ($orig) {
                $clean = ltrim($orig, '/');
                $small = preg_replace('/(\.[a-zA-Z0-9]+)$/', '_sm$1', $clean);
                $fullSmall = public_path($small);
                $display = file_exists($fullSmall) ? $small : $clean;
            }
        @endphp
        @if ($display)
            <img src="/{{ $display }}" alt="{{ $product->name }}" loading="lazy"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
        @else
            <div class="flex items-center justify-center h-full w-full text-gray-400 text-sm">Sem imagem</div>
        @endif
        <div class="absolute top-2 left-2 flex gap-1">
            @if ($product->category)
                <span class="badge badge-neutral badge-xs">{{ $product->category->name }}</span>
            @endif
            @if ($product->is_featured ?? false)
                <span class="badge badge-primary badge-xs">Destaque</span>
            @endif
            @php
                $showExpire = false;
                $expireLabel = null;
                if (
                    method_exists($product, 'isDiscountActive') &&
                    $product->isDiscountActive() &&
                    $product->discount_ends_at
                ) {
                    $diffSec = $product->discount_ends_at->diffInSeconds(now(), false);
                    if ($diffSec > 0) {
                        // future
                        $hours = $product->discount_ends_at->diffInHours();
                        if ($hours < 48) {
                            $showExpire = true;
                            $expireLabel =
                                'Expira em ' .
                                ($hours >= 1 ? $hours . 'h' : $product->discount_ends_at->diffInMinutes() . 'm');
                        }
                    }
                }
            @endphp
            @if ($showExpire)
                <span class="badge badge-error badge-xs">{{ $expireLabel }}</span>
            @endif
        </div>
    </a>

    <div class="flex flex-col flex-1 p-3">
        <h3 class="font-medium text-sm leading-tight line-clamp-2 min-h-[2.5rem]">
            <a href="{{ route('product.show', $product->slug) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        <p class="mt-2 text-xs text-gray-600 line-clamp-2 min-h-[2.25rem]">
            {{ Str::limit(strip_tags($product->short_description ?? $product->description), 120) }}
        </p>

        @if ($showEntity && $product->entity)
            <div class="mt-2 flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wide text-gray-500">{{ $product->entity->name }}</span>
            </div>
        @endif

        <div class="mt-3 flex items-end justify-between">
            <div class="space-y-0.5">
                @if (!is_null($product->price))
                    @php
                        $hasDiscount = method_exists($product, 'isDiscountActive') && $product->isDiscountActive();
                    @endphp
                    @if ($hasDiscount)
                        <div class="flex items-baseline gap-1">
                            <span
                                class="text-xs line-through text-gray-400">{{ number_format($product->price, 2, ',', '.') }}
                                MT</span>
                            <span
                                class="font-semibold text-sm text-red-600">{{ number_format($product->discountedPrice(), 2, ',', '.') }}
                                MT</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span
                                class="inline-block bg-red-100 text-red-700 text-[10px] font-semibold px-1.5 py-0.5 rounded">-{{ rtrim(rtrim(number_format($product->discountPercent(), 2, ',', '.'), '0'), ',') }}%</span>
                            <span class="text-[10px] text-gray-500">Poupa
                                {{ number_format($product->discountAmount(), 2, ',', '.') }} MT</span>
                        </div>
                    @else
                        <div class="font-semibold text-sm">
                            {{ number_format($product->price, 2, ',', '.') }} MT
                        </div>
                    @endif
                @endif
                @if ($product->views_count ?? false)
                    <div class="text-[10px] text-gray-500">{{ $product->views_count }} visualizações</div>
                @endif
            </div>
            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-xs btn-primary">Ver</a>
        </div>
    </div>
</div>
