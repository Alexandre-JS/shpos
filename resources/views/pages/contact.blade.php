@extends('layouts.app')
@section('title', 'Contacto')
@section('meta_description', 'Entre em contacto com a equipa da ' . config('app.name') . '.')
@section('content')
<div class="max-w-2xl mx-auto space-y-8 pb-16">

    <div class="text-center space-y-2 pt-4">
        <h1 class="text-3xl font-bold text-gray-900">Contacto</h1>
        <p class="text-gray-500 text-sm">Estamos disponíveis para ajudar empresas e clientes.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
        <div class="bg-white border rounded p-6 space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background:#EEF2FF">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#4F46E5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Email</p>
                    <a href="mailto:suporte@{{ str_replace(['http://','https://','www.'], '', config('app.url')) }}"
                       class="text-sm font-medium link">
                        suporte@plataforma.co.mz
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white border rounded p-6 space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background:#f0fdf4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">WhatsApp</p>
                    <a href="https://wa.me/258840000000" target="_blank" class="text-sm font-medium link">
                        +258 84 000 0000
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded p-6 space-y-4">
        <h2 class="font-semibold text-gray-800">Horário de atendimento</h2>
        <div class="text-sm text-gray-600 space-y-1">
            <div class="flex justify-between">
                <span>Segunda – Sexta</span>
                <span class="font-medium">08:00 – 17:00</span>
            </div>
            <div class="flex justify-between">
                <span>Sábado</span>
                <span class="font-medium">09:00 – 13:00</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Domingo</span>
                <span>Encerrado</span>
            </div>
        </div>
        <p class="text-xs text-gray-400 pt-1">
            Fora do horário, envie um email e respondemos no próximo dia útil.
        </p>
    </div>

    <div class="bg-white border rounded p-6 space-y-3">
        <h2 class="font-semibold text-gray-800">Para empresas</h2>
        <p class="text-sm text-gray-600">
            Quer registar o seu negócio na plataforma ou tem dúvidas sobre como funciona?
        </p>
        <a href="{{ route('register.show') }}" class="btn btn-primary btn-sm">Registar empresa →</a>
        <a href="{{ route('about') }}" class="btn btn-outline btn-sm ml-2">Saber mais</a>
    </div>
</div>
@endsection
