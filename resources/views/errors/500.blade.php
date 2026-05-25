@extends('layouts.app')
@section('title', 'Erro do servidor')

@section('content')
<div class="max-w-lg mx-auto py-24 text-center space-y-6">
    <p class="text-8xl font-black text-gray-100">500</p>
    <div class="space-y-2">
        <h1 class="text-2xl font-bold text-gray-800">Algo correu mal</h1>
        <p class="text-gray-500">Ocorreu um erro interno. Estamos a trabalhar para resolver o problema.</p>
    </div>
    <div class="flex justify-center gap-3 pt-2">
        <a href="{{ route('home') }}" class="btn btn-primary">Ir para a página inicial</a>
    </div>
</div>
@endsection
