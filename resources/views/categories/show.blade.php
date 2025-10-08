@extends('layouts.app')
@section('title', $category->name)
@section('content')
    <x-app-container class="space-y-8">
        <header class="space-y-2">
            <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
            @if ($category->type)
                <p class="text-sm text-gray-500">Tipo: {{ ucfirst($category->type) }}</p>
            @endif
        </header>
        <section>
            @include('partials.product-grid-paginated', ['paginator' => $products])
        </section>
    </x-app-container>
@endsection
