@props(['product', 'showEntity' => false])

<?php
// Small helper formatting (kept in blade for quick iteration)
use Illuminate\Support\Str;
?>

<div class="card h-100 product-card overflow-hidden shadow-sm">
    <a href="{{ route('product.show', $product->publicRouteParameters()) }}" class="ratio ratio-4x3 d-block overflow-hidden bg-light text-decoration-none">
        @php
            $image = $product->primary_image_url ?? null;
        @endphp
        @if ($image)
            <img src="{{ $image }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover" />
        @else
            <div class="d-flex align-items-center justify-content-center h-100 w-100 text-muted small">Sem imagem</div>
        @endif
        <div class="position-absolute top-0 start-0 m-2 d-flex gap-1">
            @if ($product->is_featured ?? false)
                <span class="badge text-bg-primary" style="font-size:.625rem;">Destaque</span>
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
                <span class="badge text-bg-danger" style="font-size:.625rem;">{{ $expireLabel }}</span>
            @endif
        </div>
    </a>

    <div class="card-body d-flex flex-column p-3">
        <h3 class="fw-medium small lh-sm truncate-2 mb-0" style="min-height:2.5rem;">
            <a href="{{ route('product.show', $product->publicRouteParameters()) }}" class="link-body-emphasis text-decoration-none">
                {{ $product->name }}
            </a>
        </h3>
        <p class="mt-2 small text-muted truncate-2 mb-0" style="min-height:2.25rem;">
            {{ Str::limit(strip_tags($product->short_description ?? $product->description), 120) }}
        </p>

        @if ($showEntity && $product->entity)
            <div class="mt-2 d-flex align-items-center gap-2">
                <span class="text-uppercase text-muted" style="font-size:.6875rem;letter-spacing:.05em;">{{ $product->entity->name }}</span>
            </div>
        @endif

        <div class="mt-3 d-flex align-items-end justify-content-between">
            <div class="vstack gap-0">
                @if (!is_null($product->price))
                    @php $hasDiscount = method_exists($product,'isDiscountActive') && $product->isDiscountActive(); @endphp
                    @if ($hasDiscount)
                        <div class="d-flex align-items-baseline gap-1">
                            <span class="small text-decoration-line-through text-muted">{{ number_format($product->price, 2, ',', '.') }} MT</span>
                            <span class="fw-semibold small text-danger">{{ number_format($product->discountedPrice(), 2, ',', '.') }} MT</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge text-bg-danger" style="font-size:.625rem;">-{{ rtrim(rtrim(number_format($product->discountPercent(), 2, ',', '.'), '0'), ',') }}%</span>
                            <span class="text-muted" style="font-size:.625rem;">Poupa {{ number_format($product->discountAmount(), 2, ',', '.') }} MT</span>
                        </div>
                    @else
                        <div class="fw-semibold small">
                            {{ number_format($product->price, 2, ',', '.') }} MT
                        </div>
                    @endif
                @endif
                @if ($product->views_count ?? false)
                    <div class="text-muted" style="font-size:.625rem;">{{ $product->views_count }} visualizações</div>
                @endif
            </div>
            <a href="{{ route('product.show', $product->publicRouteParameters()) }}" class="btn btn-sm btn-primary">Ver</a>
        </div>
    </div>
</div>
