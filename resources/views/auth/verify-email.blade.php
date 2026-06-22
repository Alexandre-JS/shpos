@extends('layouts.auth')
@section('title', 'Verificar Email')
@section('content')
    <div class="card shadow-sm"><div class="card-body p-4 vstack gap-3">
        <div class="text-center">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 text-primary" style="width:3.5rem;height:3.5rem;background:#fff7ed;">
                <i class="bi bi-envelope-check fs-3"></i>
            </div>
            <h1 class="fs-4 fw-bold mb-0">Verifique o seu email</h1>
            <p class="small text-muted mt-2 mb-0">
                Enviámos um link de confirmação para <strong>{{ auth()->user()->email }}</strong>.
                Clique no link para activar a sua conta.
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success small mb-0">{{ session('success') }}</div>
        @endif

        <div class="alert alert-warning small mb-0">
            Não recebeu o email? Verifique a pasta de spam ou reenvie o link abaixo.
        </div>

        <form method="POST" action="{{ route('verification.send') }}" class="d-grid">
            @csrf
            <button type="submit" class="btn btn-primary">Reenviar link de verificação</button>
        </form>

        <div class="text-center small">
            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                @csrf
                <button class="btn btn-link btn-sm p-0 text-danger text-decoration-none">Sair da conta</button>
            </form>
        </div>
    </div></div>
@endsection
