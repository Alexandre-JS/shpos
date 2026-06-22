@extends('layouts.app')
@section('title', 'Produtos e lojas em Moçambique')
@section('meta_description', 'Encontre produtos, serviços e lojas moçambicanas num só lugar.')

@section('content')
<section class="app-container pb-5 pt-4 pt-sm-5">
    <div class="position-relative overflow-hidden rounded-4 bg-dark shadow-lg" style="min-height:390px;">
        <img
            src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=85"
            alt="Interior de uma loja moderna"
            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="opacity:.45;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background:linear-gradient(90deg,rgba(17,24,39,.94) 0%,rgba(67,20,7,.72) 52%,rgba(17,24,39,.18) 100%);"></div>

        <div class="position-relative d-flex flex-column justify-content-center px-4 px-sm-5 py-5" style="min-height:390px;max-width:42rem;">
            <span class="d-inline-flex align-items-center gap-2 mb-4 rounded-pill border border-light border-opacity-25 bg-white bg-opacity-10 px-3 py-2 fw-bold text-uppercase align-self-start" style="font-size:.6875rem;letter-spacing:.16em;color:#ffedd5;backdrop-filter:blur(4px);">
                <i class="bi bi-star-fill"></i>Feito em Moçambique
            </span>
            <h1 class="display-5 fw-bolder lh-1 text-white">O que procura está mais perto.</h1>
            <p class="mt-3 text-white-50" style="max-width:32rem;">Descubra produtos e contacte lojas locais directamente.</p>
            <div class="mt-4 d-flex flex-wrap gap-3">
                <a href="{{ route('products') }}" class="btn btn-primary fw-bold d-inline-flex align-items-center gap-2 px-4 py-2">
                    Explorar produtos <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('entities.index') }}" class="btn btn-outline-light fw-semibold px-4 py-2">Ver lojas</a>
                <a href="{{ route('register.show') }}" class="btn btn-link text-warning fw-semibold text-decoration-none d-inline-flex align-items-center gap-1 px-2 py-2">
                    Vender na plataforma <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="border-top border-bottom border-warning-subtle" style="background:rgba(255,255,255,.65);">
    <div class="app-container py-4">
        @php
            $steps = [
                ['title' => 'Pesquise', 'text' => 'Encontre o que precisa.', 'icon' => 'bi-search'],
                ['title' => 'Compare', 'text' => 'Veja preços e detalhes.', 'icon' => 'bi-arrow-left-right'],
                ['title' => 'Contacte', 'text' => 'Fale directo com a loja.', 'icon' => 'bi-telephone'],
            ];
        @endphp
        <div class="row g-4">
            @foreach ($steps as $step)
                <div class="col-sm-4">
                    <div class="d-flex align-items-center gap-3 justify-content-sm-center">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-primary flex-shrink-0" style="width:2.75rem;height:2.75rem;background:#fff7ed;">
                            <i class="bi {{ $step['icon'] }} fs-5"></i>
                        </div>
                        <div>
                            <h3 class="small fw-bold mb-0">{{ $step['title'] }}</h3>
                            <p class="text-muted mb-0" style="font-size:.75rem;">{{ $step['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="app-container py-5">
    <div class="mb-4 d-flex align-items-end justify-content-between gap-3">
        <div>
            <p class="fw-bold text-uppercase text-primary mb-0" style="font-size:.625rem;letter-spacing:.18em;">Novidades</p>
            <h2 class="mt-1 fs-3 fw-bold mb-0">Produtos recentes</h2>
        </div>
        <a href="{{ route('products') }}" class="d-inline-flex align-items-center gap-1 small fw-semibold link-secondary text-decoration-none">
            Ver todos <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse ($recent->take(8) as $product)
            <div class="col"><x-product-card :product="$product" /></div>
        @empty
            <div class="col-12">
                <div class="rounded-4 border border-dashed bg-white px-4 py-5 text-center small text-muted">
                    Ainda não há produtos publicados.
                </div>
            </div>
        @endforelse
    </div>
</section>

@if ($entities->isNotEmpty())
<section class="app-container pb-5">
    <div class="rounded-4 border bg-white px-4 py-4 px-sm-5">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <h2 class="fs-5 fw-bold mb-0">Lojas em destaque</h2>
            <a href="{{ route('entities.index') }}" class="small fw-semibold link-primary text-decoration-none">Ver lojas</a>
        </div>
        <div class="row row-cols-3 row-cols-sm-6 g-4 mt-2">
            @foreach ($entities->take(6) as $entity)
                <div class="col">
                    <a href="{{ route('entity.show', $entity->slug) }}" class="d-block text-center text-decoration-none store-logo" title="{{ $entity->name }}">
                        <div class="mx-auto d-flex align-items-center justify-content-center overflow-hidden rounded-3 border bg-light" style="width:4rem;height:4rem;">
                            @if ($entity->logo_path && file_exists(public_path(ltrim($entity->logo_path, '/'))))
                                <img src="/{{ ltrim($entity->logo_path, '/') }}" alt="{{ $entity->name }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="bi bi-shop fs-4 text-secondary"></i>
                            @endif
                        </div>
                        <span class="mt-2 d-block text-truncate small fw-medium text-muted">{{ $entity->name }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
