@extends('layouts.dashboard')
@section('nav.dashboard', 'bg-gray-100 font-medium')
@section('header', 'Visão Geral')
@section('content')

    {{-- Mensagens de sessão --}}
    @if (session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded text-sm">
            {{ session('info') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded text-sm">
            {{ session('warning') }}
        </div>
    @endif
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 p-4 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Banner de estado pendente --}}
    @if ($entity->isPending())
        <div class="mb-6 bg-amber-50 border border-amber-300 rounded p-5">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-amber-800">Registo a aguardar aprovação</p>
                    <p class="text-sm text-amber-700 mt-1">
                        O teu perfil está em revisão. Assim que for aprovado, o teu negócio ficará visível publicamente e poderás gerir produtos e serviços.
                        Entretanto, podes completar as <a href="{{ route('dashboard.entity.settings.edit') }}" class="underline font-medium">definições da tua entidade</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6">
        <div class="p-5 bg-white rounded border space-y-2">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Produtos</h3>
            <p class="text-3xl font-bold">{{ $productsCount }}</p>
            <p class="text-xs text-gray-400">Total registado</p>
        </div>
        <div class="p-5 bg-white rounded border space-y-2">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Views (24h)</h3>
            <p class="text-3xl font-bold">{{ $views24h }}</p>
            <p class="text-xs text-gray-400">Últimas 24 horas</p>
        </div>
        <div class="p-5 bg-white rounded border space-y-2">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Entidade</h3>
            <p class="text-sm text-gray-600 line-clamp-4">{{ $entity->description }}</p>
        </div>
    </div>
@endsection
