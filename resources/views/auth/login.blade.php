@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Entrar</h1>
            <p class="text-sm text-gray-500 mt-1">Acesse o painel da sua entidade</p>
        </div>
        @if ($errors->any())
            <div class="alert alert-error mb-6 text-sm">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        <form method="POST" action="{{ route('login.perform') }}" class="card shadow p-8 space-y-6">
            @csrf
            <div class="space-y-1">
                <label for="email" class="text-xs font-medium text-gray-600">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="input" />
            </div>
            <div class="space-y-1">
                <label for="password" class="text-xs font-medium text-gray-600">Password</label>
                <input id="password" type="password" name="password" required class="input" />
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-gray-300" />
                <label for="remember" class="text-sm text-gray-600">Lembrar-me</label>
            </div>
            <div class="flex justify-between items-center pt-2 text-sm">
                <a href="{{ route('register.show') }}" class="link link-primary">Criar conta</a>
                <button class="btn btn-primary">Entrar</button>
            </div>
            <div class="text-center text-sm">
                <a href="{{ route('password.request') }}" class="text-gray-500 hover:underline">Esqueci a password</a>
            </div>
        </form>
    </div>
@endsection
