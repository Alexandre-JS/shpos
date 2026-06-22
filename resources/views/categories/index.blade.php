@extends('layouts.app')
@section('title', 'Categorias')
@section('meta_description', 'Explore todas as categorias de produtos e serviços em ' . config('app.name', 'Vitrine') . '.')
@section('content')
    <x-app-container class="py-4 vstack gap-4">
        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Categorias'],
        ]" />

        <header>
            <h1 class="fs-3 fw-bold mb-1">Categorias</h1>
            <p class="small text-muted mb-0">Explore produtos e serviços por categoria.</p>
        </header>

        @if ($categories->isEmpty())
            <x-empty icon="🗂️" title="Sem categorias" subtitle="Ainda não há categorias disponíveis." />
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 g-3">
                @foreach ($categories as $cat)
                    <div class="col">
                        <a href="{{ route('category.show', $cat->slug) }}"
                            class="card h-100 text-decoration-none entity-card text-center p-3">
                            <div class="fs-2 mb-1">{{ $cat->icon ?: '🗂️' }}</div>
                            <div class="fw-semibold small text-body">{{ $cat->name }}</div>
                            <div class="small text-muted">{{ $cat->items_count }} {{ $cat->items_count === 1 ? 'item' : 'itens' }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </x-app-container>
@endsection
