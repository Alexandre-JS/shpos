@extends('layouts.app')
@section('title', config('app.name', 'Vitrine'))
@section('meta_description', 'Descubra produtos e serviços de empresas moçambicanas. Encontre o que procura e contacte directamente o vendedor.')
@section('content')
    <x-app-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 order-2 lg:order-1 space-y-8">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="lg:col-span-3 order-1 lg:order-2 space-y-10">
                @if (isset($discounted) && $discounted->isNotEmpty())
                    <section>
                        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">Em Promoção <span
                                class="text-xs font-normal text-red-600">Descontos ativos</span></h2>
                        @include('partials.product-grid', ['items' => $discounted])
                    </section>
                @endif
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
            </div>
        </div>
    </x-app-container>
@endsection
