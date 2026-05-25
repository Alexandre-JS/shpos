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
        <meta property="product:price:amount"   content="{{ $product->discountedPrice() }}" />
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
                ['label' => $product->name],
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
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                        @if ($product->category?->name)
                            <span class="badge badge-outline">{{ $product->category->name }}</span>
                        @endif
                        <span class="text-xs text-gray-400">Views: {{ $product->views_count }}</span>
                    </div>
                    @if ($product->price)
                        @php $hasDiscount = method_exists($product,'isDiscountActive') && $product->isDiscountActive(); @endphp
                        @if ($hasDiscount)
                            <div class="flex flex-col gap-1">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-sm line-through text-gray-400">MT
                                        {{ number_format($product->price, 2, ',', '.') }}</span>
                                    <span class="text-2xl font-bold text-red-600">MT
                                        {{ number_format($product->discountedPrice(), 2, ',', '.') }}</span>
                                    <span
                                        class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded">-{{ rtrim(rtrim(number_format($product->discountPercent(), 2, ',', '.'), '0'), ',') }}%</span>
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
                            <p class="text-xl font-semibold text-green-600">MT
                                {{ number_format($product->price, 2, ',', '.') }}</p>
                        @endif
                    @endif
                </div>
                <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm md:text-base">
                    {{ $product->description }}</p>
                <div class="border rounded p-4 space-y-3 bg-white">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-base">Entidade</h2>
                        <a href="{{ route('entity.show', $product->entity->slug) }}"
                            class="text-primary text-sm hover:underline">Ver perfil</a>
                    </div>
                    <div class="text-sm space-y-1">
                        <p class="font-medium">{{ $product->entity->name }}</p>
                        <p class="text-gray-500">{{ $product->entity->location_city }}
                            {{ $product->entity->location_district }}</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm pt-2">
                        @if ($product->entity->whatsapp)
                            <x-whatsapp-button :number="$product->entity->whatsapp" :product="$product->name" size="xs" />
                        @endif
                        @if ($product->entity->phone)
                            <a class="btn btn-xs btn-outline" href="tel:{{ $product->entity->phone }}">Telefone</a>
                        @endif
                        @if ($product->entity->email)
                            <a class="btn btn-xs btn-outline" href="mailto:{{ $product->entity->email }}">Email</a>
                        @endif
                    </div>
                </div>
                <div class="pt-2">
                    <h2 class="font-semibold text-sm mb-2">Partilhar</h2>
                    <x-share-buttons :url="url()->current()" :title="$product->name" />
                </div>
            </div>
        </div>
    </x-app-container>
    @if (isset($related) && $related->isNotEmpty())
        <x-app-container class="max-w-5xl mt-6">
            <div class="border-t pt-8 space-y-6">
                <h2 class="text-lg font-semibold">Outros itens relacionados</h2>
                <div>
                    @include('partials.product-grid', ['items' => $related])
                </div>
            </div>
        </x-app-container>
    @endif
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
