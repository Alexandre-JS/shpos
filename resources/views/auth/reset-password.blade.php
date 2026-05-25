@extends('layouts.app')

@section('title', 'Nova Password')

@section('content')
    <div class="max-w-md mx-auto py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Nova Password</h1>
            <p class="text-sm text-gray-500 mt-1">Escolhe uma nova password para a tua conta.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 p-3 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="card shadow p-8 space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}" />

            <div class="space-y-1">
                <label for="email" class="text-xs font-medium text-gray-600">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}"
                    required autofocus class="input" />
            </div>

            <div class="space-y-1">
                <label for="password" class="text-xs font-medium text-gray-600">Nova Password</label>
                <input id="password" type="password" name="password" required class="input" />
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="text-xs font-medium text-gray-600">Confirmar Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="input" />
            </div>

            <div class="flex justify-end pt-2">
                <button class="btn btn-primary">Redefinir Password</button>
            </div>
        </form>
    </div>
@endsection
