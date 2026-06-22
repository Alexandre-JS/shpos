@props(['product', 'showEntity' => true])

@php
$primary = method_exists($product, 'primaryImage') ? $product->primaryImage() : null;
$orig = $primary?->path ?? $product->image_path;
$display = null;
if ($orig) {
$clean = ltrim($orig, '/');
$small = preg_replace('/(?:_lg)?(\.[a-zA-Z0-9]+)$/', '_sm$1', $clean);
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

    <a href="{{ route('product.show', $product->publicRouteParameters()) }}"
        class="card h-100 text-decoration-none product-card overflow-hidden">

        {{-- Imagem do produto --}}
        <div class="position-relative ratio ratio-1x1 bg-light overflow-hidden">
            @if ($display)
            <img src="/{{ $display }}" alt="{{ $product->name }}" loading="lazy"
                class="w-100 h-100 object-fit-contain p-3" />
            @else
            <div class="d-flex flex-column align-items-center justify-content-center h-100 gap-2" style="background:#fff7ed;">
                <i class="bi bi-bag fs-1 text-primary opacity-50"></i>
                <span class="text-primary opacity-75 small">Sem foto ainda</span>
            </div>
            @endif

            {{-- Badge de desconto --}}
            @if ($hasDiscount && $discountPct > 0)
            <span class="position-absolute top-0 start-0 m-2 badge text-bg-secondary" style="font-size:.625rem;">
                -{{ round($discountPct) }}%
            </span>
            @endif

            {{-- Badge urgência --}}
            @if ($expireLabel)
            <span class="position-absolute bottom-0 start-0 m-2 badge text-bg-danger" style="font-size:.5625rem;">
                {{ $expireLabel }}
            </span>
            @endif

            {{-- Entrega disponível --}}
            @if ($product->has_delivery ?? false)
            <span class="position-absolute bottom-0 end-0 m-2 badge text-bg-success d-flex align-items-center gap-1" style="font-size:.5625rem;">
                <i class="bi bi-truck"></i>Entrega
            </span>
            @endif
        </div>

        {{-- Informação do produto --}}
        <div class="card-body d-flex flex-column p-3 gap-1">

            {{-- Loja (se showEntity) --}}
            @if ($showEntity && $product->entity)
            <span class="text-muted text-uppercase text-truncate" style="font-size:.625rem;letter-spacing:.05em;">
                {{ $product->entity->name }}
            </span>
            @endif

            {{-- Nome --}}
            <h3 class="small fw-medium lh-sm truncate-2 text-body mb-0" style="min-height:2.5rem;">
                {{ $product->name }}
            </h3>

            {{-- Preço --}}
            <div class="mt-auto pt-2">
                @if (!is_null($product->price))
                @if ($hasDiscount)
                <div class="d-flex align-items-baseline gap-2 flex-wrap">
                    <span class="fs-6 fw-bold text-secondary">
                        {{ number_format($product->discountedPrice(), 2, ',', '.') }} MT
                    </span>
                    <span class="small text-decoration-line-through text-muted">
                        {{ number_format($product->price, 2, ',', '.') }} MT
                    </span>
                </div>
                @else
                <span class="fs-6 fw-bold text-secondary">
                    {{ number_format($product->price, 2, ',', '.') }} MT
                </span>
                @endif
                @else
                <span class="small text-muted fst-italic">Preço sob consulta</span>
                @endif
            </div>
        </div>
    </a>
