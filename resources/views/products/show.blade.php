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
<x-app-container class="max-w-5xl space-y-8">
    <div class="space-y-4">
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
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2 order-1"
            x-data='productGallery({
                images: @json($galleryImages),
                fallback: @json($fallbackImage),
                name: @json($product->name)
            })'>
            <div class="space-y-3">
                <div class="relative bg-gray-100 flex items-center justify-center rounded overflow-hidden group border"
                    style="aspect-ratio:1/1">
                    <template x-if="current">
                        <img :src="current.path_lg" :alt="current.alt"
                            class="object-contain w-full h-full transition-transform duration-[7000ms] group-hover:animate-loop-pan"
                            loading="lazy" />
                    </template>
                    <template x-if="!current">
                        <span class="text-gray-400 text-sm">Sem imagem</span>
                    </template>
                    <div class="absolute top-2 right-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded tracking-wide"
                        x-show="images.length > 1" x-transition>
                        <span x-text="index+1"></span>/<span x-text="images.length"></span>
                    </div>
                </div>
                <template x-if="images.length > 1">
                    <div class="flex gap-2 overflow-x-auto pb-1 hide-scrollbar select-none">
                        <template x-for="(img,i) in images" :key="img.id">
                            <button type="button" @click="select(i)"
                                class="relative shrink-0 w-20 h-20 border rounded overflow-hidden focus:outline-none focus:ring-2 focus:ring-primary/50"
                                :class="i === index ? 'ring-2 ring-primary border-primary' : 'border-gray-200'">
                                <img :src="img.path_sm" :alt="img.alt" class="object-cover w-full h-full" />
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        <div class="md:w-1/2 space-y-5 order-2">
            <div class="space-y-2">
                <h1 class="text-2xl md:text-3xl font-bold leading-tight">{{ $product->name }}</h1>
                <p class="text-xs text-gray-400 mt-1">{{ $product->views_count }} visualizações</p>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    @if ($product->category?->name)
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">{{ $product->category->name }}</span>
                    @endif
                </div>
                @if ($product->price)
                @php $hasDiscount = method_exists($product,'isDiscountActive') && $product->isDiscountActive(); @endphp
                @if ($hasDiscount)
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-sm line-through text-gray-400">MT
                            {{ number_format($product->price, 2, ',', '.') }}</span>
                        <span class="text-2xl font-bold text-orange-600">MT
                            {{ number_format($product->discountedPrice(), 2, ',', '.') }}</span>
                        <span
                            class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-0.5 rounded">-{{ rtrim(rtrim(number_format($product->discountPercent(), 2, ',', '.'), '0'), ',') }}%</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        Poupa MT {{ number_format($product->discountAmount(), 2, ',', '.') }}
                        @if ($product->discount_ends_at)
                        <span class="ml-2" x-data="countdown('{{ $product->discount_ends_at->toIso8601String() }}')" x-init="init()">
                            <span class="text-gray-400">expira em</span>
                            <span class="font-medium" x-text="timeLeft"></span>
                        </span>
                        @endif
                    </div>
                </div>
                @else
                <p class="text-2xl font-bold text-orange-600">MT
                    {{ number_format($product->price, 2, ',', '.') }}
                </p>
                @endif
                @endif
            </div>

            @if($product->description)
            <div class="mt-4">
                <h4 class="font-semibold text-gray-700 mb-2">Descrição</h4>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $product->description }}</p>
            </div>
            @endif

            <div class="border rounded-xl p-5 space-y-4 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b pb-3">
                    <h2 class="font-semibold text-gray-800">Vendedor</h2>
                    <a href="{{ route('entity.show', $product->entity->slug) }}"
                        class="text-orange-600 text-sm font-medium hover:underline">Ver loja completa →</a>
                </div>
                <div class="text-sm">
                    <p class="font-bold text-gray-900 text-base">{{ $product->entity->name }}</p>
                    <p class="text-gray-500 flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $product->entity->location_city }}{{ $product->entity->location_district ? ', ' . $product->entity->location_district : '' }}
                    </p>
                </div>

                <div class="space-y-2">
                    @if ($product->entity->whatsapp)
                    <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $product->entity->whatsapp) }}&text={{ urlencode('Olá, vi este produto no Shops: ' . $product->name . ' (' . url()->current() . ')') }}"
                        target="_blank"
                        class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-xl text-base transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.089.534 4.05 1.472 5.763L0 24l6.395-1.445A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.003-1.371l-.36-.214-3.716.839.875-3.601-.235-.371A9.818 9.818 0 012.182 12C2.182 6.58 6.58 2.182 12 2.182S21.818 6.58 21.818 12 17.42 21.818 12 21.818z" />
                        </svg>
                        Contactar pelo WhatsApp
                    </a>
                    @endif

                    <div class="flex gap-2">
                        @if($product->entity->phone)
                        <a href="tel:{{ $product->entity->phone }}"
                            class="flex-1 text-center border border-gray-200 hover:border-orange-300 text-gray-600 text-sm py-2 rounded-lg transition-colors">
                            Telefone
                        </a>
                        @endif
                        @if($product->entity->email)
                        <a href="mailto:{{ $product->entity->email }}"
                            class="flex-1 text-center border border-gray-200 hover:border-orange-300 text-gray-600 text-sm py-2 rounded-lg transition-colors">
                            Email
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <h2 class="font-semibold text-sm text-gray-700 mb-3 uppercase tracking-wider">Partilhar</h2>
                <div class="flex items-center gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                        class="flex-1 text-center py-2 rounded-lg border border-gray-200 text-gray-600 hover:border-orange-300 text-sm transition-colors">
                        Facebook
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' - ' . url()->current()) }}" target="_blank"
                        class="flex-1 text-center py-2 rounded-lg bg-green-500 text-white text-sm hover:bg-green-600 transition-colors">
                        WhatsApp
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href)"
                        class="flex-1 text-center py-2 rounded-lg border border-gray-200 text-gray-600 hover:border-orange-300 text-sm transition-colors">
                        Copiar link
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Secções extras --}}
    @if($moreFromEntity->count() > 0)
    <section class="mt-16 pt-8 border-t">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Mais produtos de <span class="text-orange-600">{{ $product->entity->name }}</span>
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($moreFromEntity as $related)
            <x-product-card :product="$related" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('entity.show', $product->entity->slug) }}"
                class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 text-sm font-bold uppercase tracking-wider transition-colors">
                Ver loja completa
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>
    @endif

    @if($similarProducts->count() > 0)
    <section class="mt-16 pt-8 border-t">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Produtos Semelhantes</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($similarProducts as $similar)
            <x-product-card :product="$similar" />
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