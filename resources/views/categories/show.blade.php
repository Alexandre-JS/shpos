@extends('layouts.app')
@section('title', $category->name)
@section('meta_description', 'Explore produtos e serviços na categoria ' . $category->name . ' em ' . config('app.name', 'Vitrine') . '.')
@section('content')
    <x-app-container class="py-4 vstack gap-4">
        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Todos os Produtos', 'url' => route('products')],
            ['label' => $category->name],
        ]" />

        <header class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="fs-3 fw-bold mb-1">{{ $category->name }}</h1>
                @if ($category->type)
                    <span class="badge rounded-pill text-bg-warning text-uppercase">{{ ucfirst($category->type) }}</span>
                @endif
            </div>
            <div class="rounded-pill bg-primary d-none d-sm-block" style="height:.25rem;width:2.5rem;"></div>
        </header>

        <section>
            @include('partials.product-grid-paginated', ['paginator' => $products])
        </section>
    </x-app-container>
@endsection
