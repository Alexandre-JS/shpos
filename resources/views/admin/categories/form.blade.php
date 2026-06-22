@extends('layouts.admin')
@section('title', $category->exists ? 'Editar Categoria' : 'Nova Categoria')
@section('header', $category->exists ? 'Editar Categoria' : 'Nova Categoria')
@section('nav.admin.categories', 'active')

@section('content')
<div style="max-width:32rem;">

    <div class="d-flex align-items-center gap-2 small text-muted mb-4">
        <a href="{{ route('admin.categories.index') }}" class="link-secondary text-decoration-none">Categorias</a>
        <span>/</span>
        <span class="text-body fw-medium">{{ $category->exists ? $category->name : 'Nova' }}</span>
    </div>

    @if($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif

    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="card">
        @csrf
        @if($category->exists) @method('PUT') @endif

        <div class="card-body p-4 vstack gap-3">
            <div>
                <label class="form-label small fw-medium text-muted mb-1">Nome</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-control form-control-sm" />
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Tipo</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="both"    {{ old('type', $category->type) === 'both'    ? 'selected' : '' }}>Produtos e Serviços</option>
                        <option value="product" {{ old('type', $category->type) === 'product' ? 'selected' : '' }}>Só Produtos</option>
                        <option value="service" {{ old('type', $category->type) === 'service' ? 'selected' : '' }}>Só Serviços</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Ícone (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" maxlength="10" placeholder="Ex: 🛒" class="form-control form-control-sm" />
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $category->exists ? $category->is_active : true) ? 'checked' : '' }} />
                <label class="form-check-label small" for="is_active">Activa (visível na plataforma)</label>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center p-4">
            <a href="{{ route('admin.categories.index') }}" class="small link-secondary text-decoration-none">Cancelar</a>
            <button class="btn btn-dark btn-sm">{{ $category->exists ? 'Guardar alterações' : 'Criar categoria' }}</button>
        </div>
    </form>
</div>
@endsection
