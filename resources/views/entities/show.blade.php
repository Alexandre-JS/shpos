@extends('layouts.app')
@section('title', $entity->name)
@section('content')
    <x-app-container class="space-y-8">
        <header class="space-y-4">
            <div class="flex items-start gap-4">
                @if ($entity->logo_path)
                    <div
                        class="w-24 h-24 rounded border bg-white flex items-center justify-center overflow-hidden shadow-sm">
                        <img src="/{{ $entity->logo_path }}" alt="{{ $entity->name }}" class="object-cover w-full h-full" />
                    </div>
                @else
                    <div
                        class="w-24 h-24 rounded border bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-gray-400 text-xs font-medium select-none shadow-inner">
                        SEM LOGO
                    </div>
                @endif
                <div class="space-y-2 flex-1">
                    <h1 class="text-3xl font-bold leading-tight">{{ $entity->name }}</h1>
                    <p class="text-gray-600 text-sm">{{ $entity->location_city }} {{ $entity->location_district }}</p>
                </div>
            </div>
            <p class="max-w-3xl text-gray-700 leading-relaxed">{{ $entity->description }}</p>
            <x-contact-buttons :entity="$entity" />
            <div class="pt-2">
                <x-share-buttons :url="url()->current()" :title="$entity->name" />
            </div>
        </header>

        <section>
            <h2 class="text-xl font-semibold mb-4">Produtos / Serviços</h2>
            @include('partials.product-grid', ['items' => $entity->products])
        </section>
    </x-app-container>
@endsection
