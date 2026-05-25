@extends('layouts.app')
@section('title', 'Acesso negado')

@section('content')
<div class="max-w-lg mx-auto py-24 text-center space-y-6">
    <p class="text-8xl font-black text-gray-100">403</p>
    <div class="space-y-2">
        <h1 class="text-2xl font-bold text-gray-800">Acesso negado</h1>
        <p class="text-gray-500">{{ $exception->getMessage() ?: 'Não tens permissão para aceder a esta página.' }}</p>
    </div>
    <div class="flex justify-center gap-3 pt-2">
        <a href="{{ route('home') }}" class="btn btn-primary">Ir para a página inicial</a>
        @guest
            <a href="{{ route('login.show') }}" class="btn btn-outline">Entrar</a>
        @endguest
    </div>
</div>
@endsection
