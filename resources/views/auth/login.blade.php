@extends('layouts.auth')
@section('title', 'Entrar')

@section('content')
        <div class="text-center text-white">
            <h1 class="fs-3 fw-bold mb-1">Entrar</h1>
            <p class="small mb-0 text-white-50">Acesse o painel da sua entidade</p>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger small mb-0">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login.perform') }}" class="card shadow-sm">
            <div class="card-body p-4 vstack gap-3">
                @csrf
                <div>
                    <label for="email" class="form-label small fw-medium text-muted">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" />
                </div>
                <div>
                    <label for="password" class="form-label small fw-medium text-muted">Password</label>
                    <input id="password" type="password" name="password" required class="form-control" />
                </div>
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                    <label for="remember" class="form-check-label small">Lembrar-me</label>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-1">
                    <a href="{{ route('register.show') }}" class="link-primary text-decoration-none small">Criar conta</a>
                    <button class="btn btn-primary">Entrar</button>
                </div>
                <div class="text-center small">
                    <a href="{{ route('password.request') }}" class="link-secondary text-decoration-none">Esqueci a password</a>
                </div>
            </div>
        </form>
@endsection
