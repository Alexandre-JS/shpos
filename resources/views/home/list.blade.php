@extends('layouts.app')
@section('title', $title ?? 'Produtos e Serviços')
@section('meta_description', 'Explore ' . strtolower($title ?? 'produtos e serviços') . ' de empresas moçambicanas em ' . config('app.name', 'Vitrine') . '.')
@section('content')
    <x-app-container class="py-4">
        <div class="row g-4">
            <div class="col-lg-3 order-2 order-lg-1">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <h1 class="fs-3 fw-bold mb-4">{{ $title }}</h1>
                <form method="GET" class="mb-4 d-flex align-items-center gap-3 small">
                    @foreach (request()->except('promo', 'page') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <div class="form-check m-0">
                        <input class="form-check-input" type="checkbox" id="promoCheck" name="promo" value="1" @checked(request('promo'))
                            onchange="this.form.submit()">
                        <label class="form-check-label" for="promoCheck">Em promoção</label>
                    </div>
                    @if (request('promo'))
                        <a href="{{ request()->fullUrlWithQuery(['promo' => null, 'page' => null]) }}"
                            class="small link-secondary text-decoration-none">Limpar</a>
                    @endif
                </form>
                @include('partials.product-grid-paginated', ['paginator' => $products])
            </div>
        </div>
    </x-app-container>
@endsection
