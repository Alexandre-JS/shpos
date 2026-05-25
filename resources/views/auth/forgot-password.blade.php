@extends('layouts.app')

@section('title', 'Recuperar Password')

@section('content')
    <div class="max-w-md mx-auto py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Recuperar Password</h1>
            <p class="text-sm text-gray-500 mt-1">Introduz o teu email e enviamos um link para redefinires a password.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 p-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 p-3 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.send') }}" class="card shadow p-8 space-y-6">
            @csrf
            <div class="space-y-1">
                <label for="email" class="text-xs font-medium text-gray-600">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    required autofocus class="input" />
            </div>

            <div class="flex justify-between items-center pt-2 text-sm">
                <a href="{{ route('login.show') }}" class="link link-primary">Voltar ao login</a>
                <button class="btn btn-primary">Enviar link</button>
            </div>
        </form>
    </div>
@endsection
