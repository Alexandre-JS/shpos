@extends('layouts.app')
@section('title', $entity->name)
@section('content')
    <x-app-container class="space-y-8">
        <header class="space-y-2">
            <h1 class="text-3xl font-bold">{{ $entity->name }}</h1>
            <p class="text-gray-600">{{ $entity->location_city }} {{ $entity->location_district }}</p>
            <p class="max-w-3xl text-gray-700">{{ $entity->description }}</p>
            <x-contact-buttons :entity="$entity" />
        </header>

        <section>
            <h2 class="text-xl font-semibold mb-4">Produtos / Serviços</h2>
            @include('partials.product-grid', ['items' => $entity->products])
        </section>
    </x-app-container>
@endsection
