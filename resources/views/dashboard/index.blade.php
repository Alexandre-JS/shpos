@extends('layouts.dashboard')
@section('nav.dashboard', 'bg-gray-100 font-medium')
@section('header', 'Visão Geral')
@section('content')
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
