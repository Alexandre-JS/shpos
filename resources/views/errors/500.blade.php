@extends('layouts.app')
@section('title', 'Erro do servidor')

@section('content')
<div class="app-container py-5 my-5 text-center vstack gap-4" style="max-width:32rem;">
    <p class="display-1 fw-bolder text-body-tertiary mb-0">500</p>
    <div class="vstack gap-2">
        <h1 class="fs-3 fw-bold mb-0">Algo correu mal</h1>
        <p class="text-muted mb-0">Ocorreu um erro interno. Estamos a trabalhar para resolver o problema.</p>
    </div>
    <div class="d-flex justify-content-center gap-2 pt-2">
        <a href="{{ route('home') }}" class="btn btn-primary">Ir para a página inicial</a>
    </div>
</div>
@endsection
