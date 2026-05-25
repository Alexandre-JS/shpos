@extends('layouts.app')
@section('title', 'Página não encontrada')

@section('content')
<div class="max-w-lg mx-auto py-24 text-center space-y-6">
    <p class="text-8xl font-black text-gray-100">404</p>
    <div class="space-y-2">
        <h1 class="text-2xl font-bold text-gray-800">Página não encontrada</h1>
        <p class="text-gray-500">O endereço que procuras não existe ou foi removido.</p>
    </div>
    <div class="flex justify-center gap-3 pt-2">
        <a href="{{ route('home') }}" class="btn btn-primary">Ir para a página inicial</a>
        <a href="{{ url()->previous() }}" class="btn btn-outline">Voltar atrás</a>
    </div>
</div>
@endsection
