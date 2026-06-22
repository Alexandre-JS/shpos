@extends('layouts.admin')
@section('title', 'Categorias')
@section('header', 'Categorias')
@section('nav.admin.categories', 'active')

@section('content')
<div class="d-flex justify-content-end">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark btn-sm">+ Nova categoria</a>
</div>

<div class="card">
    @if($categories->isEmpty())
        <p class="small text-muted p-5 text-center mb-0">Nenhuma categoria criada.</p>
    @else
        <ul class="list-group list-group-flush">
            @foreach($categories as $cat)
                <li class="list-group-item p-4 d-flex align-items-center gap-3">
                    <div class="fs-4 text-center flex-shrink-0" style="width:2rem;">{{ $cat->icon ?? '—' }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <p class="fw-medium mb-0">{{ $cat->name }}</p>
                            <span class="badge text-bg-light border text-muted" style="font-size:.625rem;">
                                {{ ['product' => 'Produto', 'service' => 'Serviço', 'both' => 'Ambos'][$cat->type] }}
                            </span>
                            @if(!$cat->is_active)
                                <span class="badge text-bg-secondary" style="font-size:.625rem;">Inactiva</span>
                            @endif
                        </div>
                        <p class="small text-muted mt-1 mb-0">{{ $cat->products_count }} produto(s) · slug: {{ $cat->slug }}</p>
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline-secondary btn-sm">Editar</a>

                        <form method="POST" action="{{ route('admin.categories.toggle', $cat) }}" class="m-0">
                            @csrf @method('PUT')
                            <button class="btn btn-sm {{ $cat->is_active ? 'btn-outline-secondary' : 'btn-primary' }}">
                                {{ $cat->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="m-0">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm {{ $cat->products_count > 0 ? 'disabled' : '' }}"
                                {{ $cat->products_count > 0 ? 'disabled' : '' }}
                                onclick="{{ $cat->products_count > 0 ? 'return false' : "return confirm('Eliminar «{$cat->name}»?')" }}">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
