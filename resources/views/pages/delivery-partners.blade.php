@extends('layouts.app')
@section('title', 'Parceiros de Entrega')
@section('meta_description', 'Conheça os parceiros de entrega da ' . config('app.name') . ' em Moçambique.')
@section('content')
<div class="app-container py-4 vstack gap-4 pb-5" style="max-width:48rem;">

    <div class="text-center vstack gap-3 pt-4">
        <h1 class="fs-2 fw-bold mb-0">Parceiros de Entrega</h1>
        <p class="text-muted small mx-auto mb-0" style="max-width:36rem;">
            Empresas parceiras que garantem a entrega dos produtos que encontra nesta plataforma.
            Contacte directamente o parceiro para combinar a entrega.
        </p>
    </div>

    <div class="alert alert-warning d-flex gap-3 mb-0">
        <i class="bi bi-info-circle fs-5 flex-shrink-0"></i>
        <p class="mb-0">A {{ config('app.name') }} facilita a ligação com parceiros de entrega mas não é responsável pela execução dos serviços. Coordene directamente com o parceiro.</p>
    </div>

    @if ($partners->isEmpty())
        <div class="card"><div class="card-body p-5 text-center text-muted">
            <i class="bi bi-box-seam fs-1 opacity-25 d-block mb-3"></i>
            <p class="small mb-0">Parceiros de entrega em breve.</p>
            <p class="small text-muted mt-1 mb-0">A nossa rede de parceiros está a ser constituída.</p>
        </div></div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 g-3">
            @foreach ($partners as $partner)
                <div class="col">
                    <div class="card h-100 product-card">
                        <div class="card-body vstack gap-3">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <h2 class="fw-semibold fs-6 mb-0">{{ $partner->name }}</h2>
                                <span class="badge text-bg-success flex-shrink-0">Activo</span>
                            </div>
                            @if ($partner->description)
                                <p class="small text-secondary-emphasis mb-0">{{ $partner->description }}</p>
                            @endif
                            @if ($partner->coverage_areas)
                                <div class="d-flex align-items-center gap-2 small text-muted">
                                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                                    <span>{{ $partner->coverage_areas }}</span>
                                </div>
                            @endif
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                @if ($partner->phone)
                                    <a href="tel:{{ $partner->phone }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-telephone"></i>{{ $partner->phone }}
                                    </a>
                                @endif
                                @if ($partner->email)
                                    <a href="mailto:{{ $partner->email }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-envelope"></i>{{ $partner->email }}
                                    </a>
                                @endif
                                @if ($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-globe"></i>Website
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card"><div class="card-body vstack gap-3">
        <h2 class="fw-semibold fs-6 mb-0">É uma empresa de entregas?</h2>
        <p class="small text-secondary-emphasis mb-0">
            Se oferece serviços de entregas em Moçambique e quer fazer parte da nossa rede de parceiros,
            entre em contacto connosco.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-sm align-self-start">Contactar →</a>
    </div></div>
</div>
@endsection
