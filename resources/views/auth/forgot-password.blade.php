@extends('layouts.auth')

@section('title', 'Recuperar Password')

@section('content')
        <div class="text-center text-white">
            <h1 class="fs-3 fw-bold mb-1">Recuperar Password</h1>
            <p class="small text-white-50 mb-0">Introduz o teu email e enviamos um link para redefinires a password.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success small mb-0">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small mb-0">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.send') }}" class="card shadow-sm">
            <div class="card-body p-4 vstack gap-3">
                @csrf
                <div>
                    <label for="email" class="form-label small fw-medium text-muted">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" />
                </div>

                <div class="d-flex justify-content-between align-items-center pt-1">
                    <a href="{{ route('login.show') }}" class="link-primary text-decoration-none small">Voltar ao login</a>
                    <button class="btn btn-primary">Enviar link</button>
                </div>
            </div>
        </form>
@endsection
