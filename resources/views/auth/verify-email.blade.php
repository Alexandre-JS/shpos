@extends('layouts.app')
@section('title', 'Verificar Email')
@section('content')
<div class="max-w-md mx-auto mt-10 bg-white border rounded p-8 shadow-sm space-y-5">
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full mb-4" style="background:#EEF2FF">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#4F46E5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-800">Verifique o seu email</h1>
        <p class="text-sm text-gray-500 mt-2">
            Enviámos um link de confirmação para <strong>{{ auth()->user()->email }}</strong>.
            Clique no link para activar a sua conta.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-amber-50 border border-amber-200 rounded p-4 text-sm text-amber-800">
        Não recebeu o email? Verifique a pasta de spam ou reenvie o link abaixo.
    </div>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary w-full">
            Reenviar link de verificação
        </button>
    </form>

    <div class="text-center text-xs text-gray-400">
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button class="text-red-400 hover:underline">Sair da conta</button>
        </form>
    </div>
</div>
@endsection
