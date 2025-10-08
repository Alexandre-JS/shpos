@extends('layouts.app')
@section('content')
    <x-app-container class="space-y-10">
        {{-- Search bar movida para o nav global --}}

        <section>
            <h2 class="text-xl font-semibold mb-4">Recentemente Adicionados</h2>
            @include('partials.product-grid', ['items' => $recent])
        </section>
        <section>
            <h2 class="text-xl font-semibold mb-4">Mais Procurados</h2>
            @include('partials.product-grid', ['items' => $mostViewed])
        </section>
        <section>
            <h2 class="text-xl font-semibold mb-4">Todos</h2>
            @include('partials.product-grid-paginated', ['paginator' => $products])
        </section>
    </x-app-container>
@endsection
