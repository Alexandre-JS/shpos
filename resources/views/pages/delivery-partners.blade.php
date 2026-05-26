@extends('layouts.app')
@section('title', 'Parceiros de Entrega')
@section('meta_description', 'Conheça os parceiros de entrega da ' . config('app.name') . ' em Moçambique.')
@section('content')
<div class="max-w-3xl mx-auto space-y-8 pb-16">

    <div class="text-center space-y-3 pt-4">
        <h1 class="text-3xl font-bold text-gray-900">Parceiros de Entrega</h1>
        <p class="text-gray-500 text-sm max-w-xl mx-auto">
            Empresas parceiras que garantem a entrega dos produtos que encontra nesta plataforma.
            Contacte directamente o parceiro para combinar a entrega.
        </p>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded p-4 text-sm text-amber-800 flex gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p>A {{ config('app.name') }} facilita a ligação com parceiros de entrega mas não é responsável pela execução dos serviços. Coordene directamente com o parceiro.</p>
    </div>

    @if ($partners->isEmpty())
        <div class="bg-white border rounded p-10 text-center text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-sm">Parceiros de entrega em breve.</p>
            <p class="text-xs mt-1">A nossa rede de parceiros está a ser constituída.</p>
        </div>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($partners as $partner)
                <div class="bg-white border rounded p-6 space-y-3 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between gap-2">
                        <h2 class="font-semibold text-gray-800 text-base">{{ $partner->name }}</h2>
                        <span class="badge badge-success text-[10px] shrink-0">Activo</span>
                    </div>
                    @if ($partner->description)
                        <p class="text-sm text-gray-600">{{ $partner->description }}</p>
                    @endif
                    @if ($partner->coverage_areas)
                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $partner->coverage_areas }}</span>
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-3 pt-1">
                        @if ($partner->phone)
                            <a href="tel:{{ $partner->phone }}"
                               class="inline-flex items-center gap-1.5 text-xs text-gray-600 hover:text-gray-900 border rounded px-2.5 py-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $partner->phone }}
                            </a>
                        @endif
                        @if ($partner->email)
                            <a href="mailto:{{ $partner->email }}"
                               class="inline-flex items-center gap-1.5 text-xs text-gray-600 hover:text-gray-900 border rounded px-2.5 py-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $partner->email }}
                            </a>
                        @endif
                        @if ($partner->website)
                            <a href="{{ $partner->website }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-xs text-gray-600 hover:text-gray-900 border rounded px-2.5 py-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Website
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="bg-white border rounded p-6 space-y-3">
        <h2 class="font-semibold text-gray-800">É uma empresa de entregas?</h2>
        <p class="text-sm text-gray-600">
            Se oferece serviços de entregas em Moçambique e quer fazer parte da nossa rede de parceiros,
            entre em contacto connosco.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Contactar →</a>
    </div>
</div>
@endsection
