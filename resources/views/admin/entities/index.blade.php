@extends('layouts.admin')
@section('title', 'Empresas / Lojas')
@section('header', 'Empresas e Lojas')
@section('nav.admin.entities', 'active')

@section('content')

{{-- Tabs de estado --}}
<ul class="nav nav-tabs">
    @foreach(['pending' => 'Pendentes', 'approved' => 'Aprovadas', 'rejected' => 'Rejeitadas'] as $s => $label)
        <li class="nav-item">
            <a href="{{ route('admin.entities.index', ['status' => $s, 'q' => $q]) }}" class="nav-link {{ $status === $s ? 'active' : '' }}">
                {{ $label }}
                @if($counts[$s] > 0)
                    <span class="ms-1 small {{ $s === 'pending' ? 'text-warning-emphasis fw-bold' : 'text-muted' }}">({{ $counts[$s] }})</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>

<div class="card border-top-0 rounded-top-0">

    {{-- Barra de pesquisa --}}
    <div class="card-header bg-white">
        <form method="GET" action="{{ route('admin.entities.index') }}" class="d-flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}" />
            <input type="text" name="q" value="{{ $q }}" placeholder="Pesquisar por nome ou cidade..." class="form-control form-control-sm" />
            <button class="btn btn-dark btn-sm">Pesquisar</button>
            @if($q)
                <a href="{{ route('admin.entities.index', ['status' => $status]) }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
            @endif
        </form>
    </div>

    @if($entities->isEmpty())
        <p class="small text-muted p-5 text-center mb-0">Nenhuma empresa encontrada.</p>
    @else
        <ul class="list-group list-group-flush">
            @foreach($entities as $entity)
                <li class="list-group-item p-4 d-flex flex-column flex-sm-row align-items-sm-center gap-3">
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <p class="fw-semibold mb-0">{{ $entity->name }}</p>
                            @if($entity->is_featured)
                                <span class="badge text-bg-warning" style="font-size:.625rem;">Destaque</span>
                            @endif
                            @if(!$entity->is_active && $entity->status === 'approved')
                                <span class="badge text-bg-secondary" style="font-size:.625rem;">Desactivada</span>
                            @endif
                            <span class="badge text-bg-light border text-muted" style="font-size:.625rem;">{{ ucfirst($entity->plan_type) }}</span>
                        </div>
                        <p class="small text-muted mt-1 mb-0">
                            {{ $entity->user->email }} &bull; {{ $entity->location_city }}
                            @if($entity->location_district) · {{ $entity->location_district }} @endif
                        </p>
                        <p class="small text-muted mt-1 mb-0">
                            {{ $entity->products_count }} produto(s) &bull; Registado {{ $entity->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2 flex-shrink-0">
                        <a href="{{ route('admin.entities.edit', $entity) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                        <a href="{{ route('entity.show', $entity->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm">Ver perfil</a>

                        @if($entity->status !== 'approved')
                            <form method="POST" action="{{ route('admin.entities.approve', $entity) }}" class="m-0">
                                @csrf @method('PUT')
                                <button class="btn btn-success btn-sm">Aprovar</button>
                            </form>
                        @endif
                        @if($entity->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.entities.reject', $entity) }}" class="m-0">
                                @csrf @method('PUT')
                                <button class="btn btn-warning btn-sm" onclick="return confirm('Rejeitar «{{ $entity->name }}»?')">Rejeitar</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.entities.toggle', $entity) }}" class="m-0">
                            @csrf @method('PUT')
                            <button class="btn btn-sm {{ $entity->is_active ? 'btn-outline-secondary' : 'btn-primary' }}">
                                {{ $entity->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.entities.destroy', $entity) }}" class="m-0">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Eliminar permanentemente «{{ $entity->name }}»? Esta acção não pode ser revertida.')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="card-footer bg-white">{{ $entities->links() }}</div>
    @endif
</div>
@endsection
