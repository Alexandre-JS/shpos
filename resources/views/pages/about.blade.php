@extends('layouts.app')
@section('title', 'Sobre Nós')
@section('meta_description', 'Conheça a plataforma ' . config('app.name') . ' — o directório digital de empresas e lojas moçambicanas.')
@section('content')
<div class="max-w-3xl mx-auto space-y-10 pb-16">

    <div class="text-center space-y-3 pt-4">
        <h1 class="text-3xl font-bold text-gray-900">Sobre a {{ config('app.name') }}</h1>
        <p class="text-gray-500 text-base max-w-xl mx-auto">
            A plataforma que conecta empresas moçambicanas aos seus clientes.
        </p>
    </div>

    <div class="bg-white border rounded p-8 space-y-6">
        <div class="space-y-3">
            <h2 class="text-lg font-semibold" style="color:#1E1B4B">O que somos</h2>
            <p class="text-sm text-gray-600 leading-relaxed">
                A <strong>{{ config('app.name') }}</strong> é um directório digital moçambicano que reúne lojas,
                empresas e prestadores de serviço num único lugar. Qualquer empresa registada pode criar
                o seu perfil, listar produtos e serviços, e ser encontrada por clientes em todo o país.
            </p>
            <p class="text-sm text-gray-600 leading-relaxed">
                O nosso objectivo é simples: tornar as empresas moçambicanas mais visíveis e acessíveis,
                independentemente da sua dimensão ou localização.
            </p>
        </div>

        <hr />

        <div class="space-y-3">
            <h2 class="text-lg font-semibold" style="color:#1E1B4B">A nossa missão</h2>
            <p class="text-sm text-gray-600 leading-relaxed">
                Democratizar o comércio digital em Moçambique. Acreditamos que cada empresa, seja uma
                pequena loja no bairro ou uma grande distribuidora, merece ter presença digital e
                alcançar novos clientes.
            </p>
        </div>

        <hr />

        <div class="grid sm:grid-cols-3 gap-6 pt-2">
            <div class="text-center space-y-2">
                <div class="text-3xl font-bold" style="color:#4F46E5">+0</div>
                <p class="text-xs text-gray-500">Empresas registadas</p>
            </div>
            <div class="text-center space-y-2">
                <div class="text-3xl font-bold" style="color:#F43F5E">+0</div>
                <p class="text-xs text-gray-500">Produtos listados</p>
            </div>
            <div class="text-center space-y-2">
                <div class="text-3xl font-bold" style="color:#059669">+0</div>
                <p class="text-xs text-gray-500">Cidades cobertas</p>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded p-8 space-y-4">
        <h2 class="text-lg font-semibold" style="color:#1E1B4B">Quer listar o seu negócio?</h2>
        <p class="text-sm text-gray-600">
            Registe a sua empresa gratuitamente e comece a mostrar os seus produtos e serviços.
            Aprovação em 24–48 horas.
        </p>
        <a href="{{ route('register.show') }}" class="btn btn-primary btn-sm">
            Registar agora →
        </a>
    </div>

    <div class="text-center text-sm text-gray-500">
        Tem perguntas? <a href="{{ route('contact') }}" class="link">Entre em contacto</a> connosco.
    </div>
</div>
@endsection
