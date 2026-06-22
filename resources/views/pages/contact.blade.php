@extends('layouts.app')
@section('title', 'Contacto')
@section('meta_description', 'Entre em contacto com a equipa da ' . config('app.name') . '.')
@section('content')
<div class="app-container py-4 vstack gap-4 pb-5" style="max-width:42rem;">

    <div class="text-center vstack gap-2 pt-4">
        <span class="badge rounded-pill text-bg-warning text-uppercase align-self-center" style="letter-spacing:.2em;">Suporte</span>
        <h1 class="fs-2 fw-bold mb-0">Contacto</h1>
        <p class="text-muted small mb-0">Estamos disponíveis para ajudar empresas e clientes.</p>
    </div>

    <div class="row g-3">
        <div class="col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 text-primary" style="width:2.5rem;height:2.5rem;background:#fff7ed;">
                        <i class="bi bi-envelope fs-5"></i>
                    </div>
                    <div>
                        <p class="small text-muted mb-0">Email</p>
                        <a href="mailto:suporte@shops.co.mz" class="small fw-medium link-primary text-decoration-none">suporte@shops.co.mz</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 text-success" style="width:2.5rem;height:2.5rem;background:#f0fdf4;">
                        <i class="bi bi-whatsapp fs-5"></i>
                    </div>
                    <div>
                        <p class="small text-muted mb-0">WhatsApp</p>
                        <a href="https://wa.me/258840000000" target="_blank" class="small fw-medium link-success text-decoration-none">+258 84 000 0000</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body vstack gap-3">
            <h2 class="fw-bold fs-6 mb-0">Horário de atendimento</h2>
            <div class="small text-secondary-emphasis">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Segunda – Sexta</span>
                    <span class="fw-semibold text-body">08:00 – 17:00</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Sábado</span>
                    <span class="fw-semibold text-body">09:00 – 13:00</span>
                </div>
                <div class="d-flex justify-content-between py-1 text-muted">
                    <span>Domingo</span>
                    <span>Encerrado</span>
                </div>
            </div>
            <p class="small text-muted pt-1 mb-0">
                Fora do horário, envie um email e respondemos no próximo dia útil.
            </p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body vstack gap-3">
            <h2 class="fw-bold fs-6 mb-0">Para empresas</h2>
            <p class="small text-secondary-emphasis mb-0">
                Quer registar o seu negócio na plataforma ou tem dúvidas sobre como funciona?
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('register.show') }}" class="btn btn-primary btn-sm">Registar empresa →</a>
                <a href="{{ route('about') }}" class="btn btn-outline-secondary btn-sm">Saber mais</a>
            </div>
        </div>
    </div>
</div>
@endsection
