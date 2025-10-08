@extends('layouts.app')
@section('title', $product->name)
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
                        <p class="text-xl font-semibold text-green-600">MT {{ number_format($product->price, 2, ',', '.') }}
                        </p>
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
