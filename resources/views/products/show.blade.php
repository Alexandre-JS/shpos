@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <x-app-container class="max-w-5xl space-y-8">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/2 order-1">
                <div class="relative bg-gray-100 flex items-center justify-center text-gray-400 rounded overflow-hidden"
                    style="aspect-ratio:1/1">
                    @if ($product->image_path)
                        @php
                            $orig = $product->image_path;
                            $small = preg_replace('/(\.[a-zA-Z0-9]+)$/', '_sm$1', $orig);
                            if (!file_exists(public_path($small))) {
                                $small = $orig;
                            }
                        @endphp
                        <img src="/{{ $small }}" srcset="/{{ $small }} 400w, /{{ $orig }} 800w"
                            sizes="(max-width:640px) 100vw, (max-width:1024px) 50vw, 33vw" alt="{{ $product->name }}"
                            class="object-cover w-full h-full" loading="lazy" />
                    @else
                        <span>Sem imagem</span>
                    @endif
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
