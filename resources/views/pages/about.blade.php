@extends('layouts.app')
@section('title', 'Sobre Nós')
@section('meta_description', 'Conheça a plataforma ' . config('app.name') . ' — o directório digital de empresas e lojas moçambicanas.')
@section('content')
<div class="app-container py-4 vstack gap-5 pb-5" style="max-width:48rem;">

    <div class="text-center vstack gap-3 pt-4">
        <span class="badge rounded-pill text-bg-warning text-uppercase align-self-center" style="letter-spacing:.2em;">Sobre a Plataforma</span>
        <h1 class="fs-2 fw-bold mb-0">{{ config('app.name') }}</h1>
        <p class="text-muted mx-auto mb-0" style="max-width:36rem;">
            A plataforma que conecta empresas moçambicanas aos seus clientes.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4 p-sm-5 vstack gap-4">
            <div class="vstack gap-3">
                <h2 class="fs-5 fw-bold text-primary mb-0">O que somos</h2>
                <p class="small text-secondary-emphasis lh-base mb-0">
                    A <strong>{{ config('app.name') }}</strong> é um directório digital moçambicano que reúne lojas,
                    empresas e prestadores de serviço num único lugar. Qualquer empresa registada pode criar
                    o seu perfil, listar produtos e serviços, e ser encontrada por clientes em todo o país.
                </p>
                <p class="small text-secondary-emphasis lh-base mb-0">
                    O nosso objectivo é simples: tornar as empresas moçambicanas mais visíveis e acessíveis,
                    independentemente da sua dimensão ou localização.
                </p>
            </div>

            <hr class="my-0" />

            <div class="vstack gap-3">
                <h2 class="fs-5 fw-bold text-primary mb-0">A nossa missão</h2>
                <p class="small text-secondary-emphasis lh-base mb-0">
                    Democratizar o comércio digital em Moçambique. Acreditamos que cada empresa, seja uma
                    pequena loja no bairro ou uma grande distribuidora, merece ter presença digital e
                    alcançar novos clientes.
                </p>
            </div>

            <hr class="my-0" />

            <div class="row g-4 text-center pt-1">
                <div class="col-sm-4">
                    <div class="fs-2 fw-bolder text-primary">+0</div>
                    <p class="small text-muted mb-0">Empresas registadas</p>
                </div>
                <div class="col-sm-4">
                    <div class="fs-2 fw-bolder text-primary">+0</div>
                    <p class="small text-muted mb-0">Produtos listados</p>
                </div>
                <div class="col-sm-4">
                    <div class="fs-2 fw-bolder text-primary">+0</div>
                    <p class="small text-muted mb-0">Cidades cobertas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-4 p-4 p-sm-5 text-white shadow-sm vstack gap-3" style="background:var(--color-primary);">
        <h2 class="fs-5 fw-bold mb-0">Quer listar o seu negócio?</h2>
        <p class="small mb-0 opacity-90">
            Registe a sua empresa gratuitamente e comece a mostrar os seus produtos e serviços.
            Aprovação em 24–48 horas.
        </p>
        <a href="{{ route('register.show') }}" class="btn btn-light text-primary fw-bold align-self-start">Registar agora →</a>
    </div>

    <div class="text-center small text-muted">
        Tem perguntas? <a href="{{ route('contact') }}" class="link-primary text-decoration-none fw-medium">Entre em contacto</a> connosco.
    </div>
</div>
@endsection
