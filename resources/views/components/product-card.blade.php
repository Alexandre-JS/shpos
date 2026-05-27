@props(['product', 'showEntity' => true])

@php
$primary = method_exists($product, 'primaryImage') ? $product->primaryImage() : null;
$orig = $primary?->path ?? $product->image_path;
$display = null;
if ($orig) {
$clean = ltrim($orig, '/');
$small = preg_replace('/(\.[a-zA-Z0-9]+)$/', '_sm$1', $clean);
$display = file_exists(public_path($small)) ? $small : $clean;
}

$hasDiscount = method_exists($product, 'isDiscountActive') && $product->isDiscountActive();
$discountPct = $hasDiscount ? $product->discountPercent() : 0;

// Tempo restante do desconto (urgência)
$expireLabel = null;
if ($hasDiscount && $product->discount_ends_at) {
$hours = $product->discount_ends_at->diffInHours(now(), false);
if ($hours < 0 && abs($hours) < 48) {
    $expireLabel='Expira em ' . (abs($hours)>= 1 ? abs($hours) . 'h' : $product->discount_ends_at->diffInMinutes(now(), false) * -1 . 'm');
    }
    }
    @endphp

    <a href="{{ route('product.show', $product->slug) }}"
        class="group flex flex-col bg-white rounded-xl border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-200 overflow-hidden">

        {{-- Imagem do produto --}}
        <div class="relative aspect-square bg-gray-50 overflow-hidden">
            @if ($display)
            <img src="/{{ $display }}" alt="{{ $product->name }}" loading="lazy"
                class="w-full h-full object-contain p-3 group-hover:scale-105 transition-transform duration-300" />
            @else
            <div class="flex flex-col items-center justify-center h-full gap-2 bg-orange-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-orange-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="text-orange-300 text-xs">Sem foto ainda</span>
            </div>
            @endif

            {{-- Badge de desconto --}}
            @if ($hasDiscount && $discountPct > 0)
            <span class="absolute top-2 left-2 text-[10px] font-bold text-white px-2 py-0.5 rounded-md"
                style="background:var(--color-accent)">
                -{{ round($discountPct) }}%
            </span>
            @endif

            {{-- Categoria --}}
            @if ($product->category)
            <span class="absolute top-2 right-2 text-[9px] font-medium bg-white/80 backdrop-blur-sm text-gray-600 px-2 py-0.5 rounded-full border border-gray-100">
                {{ $product->category->name }}
            </span>
            @endif

            {{-- Badge urgência --}}
            @if ($expireLabel)
            <span class="absolute bottom-2 left-2 text-[9px] font-medium bg-red-500 text-white px-2 py-0.5 rounded">
                {{ $expireLabel }}
            </span>
            @endif

            {{-- Entrega disponível --}}
            @if ($product->has_delivery ?? false)
            <span class="absolute bottom-2 right-2 text-[9px] font-medium bg-green-600 text-white px-2 py-0.5 rounded flex items-center gap-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Entrega
            </span>
            @endif
        </div>

        {{-- Informação do produto --}}
        <div class="flex flex-col flex-1 px-3 py-3 gap-1">

            {{-- Loja (se showEntity) --}}
            @if ($showEntity && $product->entity)
            <span class="text-[10px] text-gray-400 uppercase tracking-wide truncate">
                {{ $product->entity->name }}
            </span>
            @endif

            {{-- Nome --}}
            <h3 class="text-sm font-medium leading-snug line-clamp-2 text-gray-800 group-hover:text-orange-600 transition-colors min-h-[2.5rem]">
                {{ $product->name }}
            </h3>

            {{-- Preço --}}
            <div class="mt-auto pt-2">
                @if (!is_null($product->price))
                @if ($hasDiscount)
                <div class="flex items-baseline gap-1.5 flex-wrap">
                    <span class="text-base font-bold" style="color:var(--color-accent)">
                        {{ number_format($product->discountedPrice(), 2, ',', '.') }} MT
                    </span>
                    <span class="text-xs line-through text-gray-400">
                        {{ number_format($product->price, 2, ',', '.') }} MT
                    </span>
                </div>
                @else
                <span class="text-base font-bold" style="color:var(--color-accent)">
                    {{ number_format($product->price, 2, ',', '.') }} MT
                </span>
                @endif
                @else
                <span class="text-xs text-gray-400 italic">Preço sob consulta</span>
                @endif
            </div>
        </div>
    </a>