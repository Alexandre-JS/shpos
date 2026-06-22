@extends('layouts.app')
@section('title', $product->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 160))
@section('og_type', 'product')
@push('meta')
@php
$primaryImg = $product->primaryImage();
$ogImg = $primaryImg
? asset('storage/' . ltrim(str_replace('storage/', '', $primaryImg->path), '/'))
: ($product->image_path ? asset($product->image_path) : asset('images/og-default.png'));
@endphp
<meta property="og:image" content="{{ $ogImg }}" />
@if($product->price)
<meta property="product:price:amount" content="{{ $product->discountedPrice() }}" />
<meta property="product:price:currency" content="MZN" />
@endif
@endpush
@section('content')
<x-app-container class="py-4 vstack gap-4" style="max-width:64rem;">
    <div>
        <x-breadcrumb :items="array_filter([
                ['label' => 'Home', 'url' => route('home')],
                $product->category
                    ? ['label' => $product->category->name, 'url' => route('category.show', $product->category->slug)]
                    : null,
                ['label' => \Illuminate\Support\Str::limit($product->name, 40)],
            ])" />
    </div>
    @php
    $galleryImages = $product->images->map(function ($img) use ($product) {
    $lg = $img->path; // já retornado como caminho (provavelmente 'storage/uploads/..._lg.ext')
    $sm = preg_replace('/_lg(\.[a-z0-9]+)$/i', '_sm$1', $lg);
    return [
    'id' => $img->id,
    'path_lg' => asset('storage/' . ltrim(str_replace('storage/', '', $lg), '/')),
    'path_sm' => asset('storage/' . ltrim(str_replace('storage/', '', $sm), '/')),
    'alt' => $product->name,
    ];
    });
    $fallbackImage = null;
    if ($product->image_path) {
    $fallbackImage = str_starts_with($product->image_path, 'http')
    ? $product->image_path
    : '/' . $product->image_path;
    }
    @endphp
    <div class="row g-4">
        <div class="col-md-6"
            x-data='productGallery({
                images: @json($galleryImages),
                fallback: @json($fallbackImage),
                name: @json($product->name)
            })'>
            <div class="vstack gap-3">
                <div class="position-relative bg-light d-flex align-items-center justify-content-center rounded overflow-hidden border" style="aspect-ratio:1/1">
                    <template x-if="current">
                        <img :src="current.path_lg" :alt="current.alt"
                            class="object-fit-contain w-100 h-100"
                            loading="lazy" />
                    </template>
                    <template x-if="!current">
                        <span class="text-muted small">Sem imagem</span>
                    </template>
                    <div class="position-absolute top-0 end-0 m-2 text-white px-2 py-1 rounded" style="background:rgba(0,0,0,.5);font-size:.625rem;"
                        x-show="images.length > 1" x-transition>
                        <span x-text="index+1"></span>/<span x-text="images.length"></span>
                    </div>
                </div>
                <template x-if="images.length > 1">
                    <div class="d-flex gap-2 overflow-auto pb-1 hide-scrollbar user-select-none">
                        <template x-for="(img,i) in images" :key="img.id">
                            <button type="button" @click="select(i)"
                                class="position-relative flex-shrink-0 border rounded overflow-hidden p-0 bg-transparent" style="width:5rem;height:5rem;"
                                :class="i === index ? 'border-primary border-2' : 'border-secondary-subtle'">
                                <img :src="img.path_sm" :alt="img.alt" class="object-fit-cover w-100 h-100" />
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        <div class="col-md-6 vstack gap-4">
            <div class="vstack gap-2">
                <h1 class="fs-2 fw-bold lh-sm mb-0">{{ $product->name }}</h1>
                <p class="small text-muted mb-0">{{ $product->views_count }} visualizações</p>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if ($product->category?->name)
                    <span class="badge rounded-pill text-bg-warning">{{ $product->category->name }}</span>
                    @endif
                </div>
                @if ($product->price)
                @php $hasDiscount = method_exists($product,'isDiscountActive') && $product->isDiscountActive(); @endphp
                @if ($hasDiscount)
                <div class="vstack gap-1">
                    <div class="d-flex align-items-baseline gap-2 flex-wrap">
                        <span class="small text-decoration-line-through text-muted">MT {{ number_format($product->price, 2, ',', '.') }}</span>
                        <span class="fs-3 fw-bold text-primary">MT {{ number_format($product->discountedPrice(), 2, ',', '.') }}</span>
                        <span class="badge text-bg-warning">-{{ rtrim(rtrim(number_format($product->discountPercent(), 2, ',', '.'), '0'), ',') }}%</span>
                    </div>
                    <div class="small text-muted">
                        Poupa MT {{ number_format($product->discountAmount(), 2, ',', '.') }}
                        @if ($product->discount_ends_at)
                        <span class="ms-2" x-data="countdown('{{ $product->discount_ends_at->toIso8601String() }}')" x-init="init()">
                            <span class="text-muted">expira em</span>
                            <span class="fw-medium" x-text="timeLeft"></span>
                        </span>
                        @endif
                    </div>
                </div>
                @else
                <p class="fs-3 fw-bold text-primary mb-0">MT {{ number_format($product->price, 2, ',', '.') }}</p>
                @endif
                @endif
            </div>

            @if($product->description)
            <div>
                <h4 class="fw-semibold fs-6 mb-2">Descrição</h4>
                <p class="text-secondary-emphasis small lh-base mb-0">{{ $product->description }}</p>
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body vstack gap-3">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                        <h2 class="fw-semibold fs-6 mb-0">Vendedor</h2>
                        <a href="{{ route('entity.show', $product->entity->slug) }}"
                            class="small fw-medium link-primary text-decoration-none">Ver loja completa →</a>
                    </div>
                    <div class="small">
                        <p class="fw-bold fs-6 mb-1">{{ $product->entity->name }}</p>
                        <p class="text-muted d-flex align-items-center gap-1 mb-0">
                            <i class="bi bi-geo-alt"></i>
                            {{ $product->entity->location_city }}{{ $product->entity->location_district ? ', ' . $product->entity->location_district : '' }}
                        </p>
                    </div>

                    <div class="vstack gap-2">
                        @if ($product->entity->whatsapp)
                        <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $product->entity->whatsapp) }}&text={{ urlencode('Olá, vi este produto no Shops: ' . $product->name . ' (' . url()->current() . ')') }}"
                            target="_blank"
                            class="btn btn-success d-flex align-items-center justify-content-center gap-2 py-2">
                            <i class="bi bi-whatsapp fs-5"></i>Contactar pelo WhatsApp
                        </a>
                        @endif

                        <div class="d-flex gap-2">
                            @if($product->entity->phone)
                            <a href="tel:{{ $product->entity->phone }}" class="btn btn-outline-secondary flex-fill">Telefone</a>
                            @endif
                            @if($product->entity->email)
                            <a href="mailto:{{ $product->entity->email }}" class="btn btn-outline-secondary flex-fill">Email</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-top">
                <h2 class="fw-semibold small text-muted mb-3 text-uppercase" style="letter-spacing:.05em;">Partilhar</h2>
                <div class="d-flex align-items-center gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                        class="btn btn-outline-secondary flex-fill">Facebook</a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' - ' . url()->current()) }}" target="_blank"
                        class="btn btn-success flex-fill">WhatsApp</a>
                    <button onclick="navigator.clipboard.writeText(window.location.href)" class="btn btn-outline-secondary flex-fill">Copiar link</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Secções extras --}}
    @if($moreFromEntity->count() > 0)
    <section class="mt-5 pt-4 border-top">
        <h2 class="fs-4 fw-bold mb-4">
            Mais produtos de <span class="text-primary">{{ $product->entity->name }}</span>
        </h2>
        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($moreFromEntity as $related)
            <div class="col"><x-product-card :product="$related" /></div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('entity.show', $product->entity->slug) }}"
                class="d-inline-flex align-items-center gap-2 link-primary small fw-bold text-uppercase text-decoration-none" style="letter-spacing:.05em;">
                Ver loja completa <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>
    @endif

    @if($similarProducts->count() > 0)
    <section class="mt-5 pt-4 border-top">
        <h2 class="fs-4 fw-bold mb-4">Produtos Semelhantes</h2>
        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($similarProducts as $similar)
            <div class="col"><x-product-card :product="$similar" /></div>
            @endforeach
        </div>
    </section>
    @endif
</x-app-container>
@endsection


@push('preload')
@if ($galleryImages->isNotEmpty())
<link rel="preload" as="image" href="{{ $galleryImages[0]['path_lg'] }}"
    imagesrcset="{{ $galleryImages[0]['path_sm'] }} 400w, {{ $galleryImages[0]['path_lg'] }} 800w" />
@if (isset($galleryImages[1]))
<link rel="prefetch" as="image" href="{{ $galleryImages[1]['path_lg'] }}" />
@endif
@endif
@endpush

@push('scripts')
<script>
    function productGallery(cfg) {
        return {
            images: cfg.images || [],
            fallback: cfg.fallback || null,
            name: cfg.name || '',
            index: 0,
            cache: new Set(),
            init() {
                // Preload atual e próximo
                this.preloadAround(this.index);
            },
            get current() {
                if (this.images.length) return this.images[this.index];
                if (this.fallback) return {
                    path: this.fallback,
                    alt: this.name
                };
                return null;
            },
            select(i) {
                if (i >= 0 && i < this.images.length) this.index = i;
                this.preloadAround(this.index);
            },
            preloadAround(i) {
                const ids = [i + 1, i - 1].filter(n => n >= 0 && n < this.images.length);
                ids.forEach(n => this.preloadImage(this.images[n].path_lg));
            },
            preloadImage(src) {
                if (!src || this.cache.has(src)) return;
                const img = new Image();
                img.src = src;
                this.cache.add(src);
            }
        }
    }

    function countdown(iso) {
        return {
            target: new Date(iso),
            timeLeft: '',
            interval: null,
            format(ms) {
                if (ms <= 0) return 'terminado';
                const sec = Math.floor(ms / 1000);
                const d = Math.floor(sec / 86400);
                const h = Math.floor((sec % 86400) / 3600);
                const m = Math.floor((sec % 3600) / 60);
                const s = sec % 60;
                if (d > 0) return `${d}d ${h}h ${m}m`;
                if (h > 0) return `${h}h ${m}m ${s}s`;
                return `${m}m ${s}s`;
            },
            tick() {
                const diff = this.target - new Date();
                this.timeLeft = this.format(diff);
                if (diff <= 0 && this.interval) {
                    clearInterval(this.interval);
                }
            },
            init() {
                this.tick();
                this.interval = setInterval(() => this.tick(), 1000);
            }
        }
    }
</script>
<style>
    @keyframes loop-pan {
        0% {
            transform: scale(1) translate(0, 0);
        }

        20% {
            transform: scale(1.05) translate(2%, -2%);
        }

        40% {
            transform: scale(1.08) translate(-2%, 2%);
        }

        60% {
            transform: scale(1.05) translate(2%, 2%);
        }

        80% {
            transform: scale(1.07) translate(-2%, -2%);
        }

        100% {
            transform: scale(1) translate(0, 0);
        }
    }

    .animate-loop-pan {
        animation: loop-pan 9s linear infinite;
    }

    .hide-scrollbar {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>
@endpush