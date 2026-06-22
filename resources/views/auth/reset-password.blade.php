@extends('layouts.auth')

@section('title', 'Nova Password')

@section('content')
        <div class="text-center text-white">
            <h1 class="fs-3 fw-bold mb-1">Nova Password</h1>
            <p class="small text-white-50 mb-0">Escolhe uma nova password para a tua conta.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger small mb-0">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="card shadow-sm">
            <div class="card-body p-4 vstack gap-3">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" />

                <div>
                    <label for="email" class="form-label small fw-medium text-muted">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus class="form-control" />
                </div>

                <div>
                    <label for="password" class="form-label small fw-medium text-muted">Nova Password</label>
                    <input id="password" type="password" name="password" required class="form-control" />
                </div>

                <div>
                    <label for="password_confirmation" class="form-label small fw-medium text-muted">Confirmar Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" />
                </div>

                <div class="d-flex justify-content-end pt-1">
                    <button class="btn btn-primary">Redefinir Password</button>
                </div>
            </div>
        </form>
@endsection
