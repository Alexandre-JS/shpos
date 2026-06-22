@extends('layouts.admin')
@section('title', 'Editar — ' . $entity->name)
@section('header', 'Editar Empresa')
@section('nav.admin.entities', 'active')

@section('content')
<div class="vstack gap-4" style="max-width:42rem;">

    <div class="d-flex align-items-center gap-2 small text-muted">
        <a href="{{ route('admin.entities.index') }}" class="link-secondary text-decoration-none">Empresas</a>
        <span>/</span>
        <span class="text-body fw-medium">{{ $entity->name }}</span>
    </div>

    @if($errors->any())
        <div class="alert alert-danger small mb-0">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.entities.update', $entity) }}" class="card">
        @csrf @method('PUT')

        {{-- Informação básica --}}
        <div class="card-body p-4 vstack gap-3 border-bottom">
            <h2 class="fw-semibold small text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Informação</h2>
            <div>
                <label class="form-label small fw-medium text-muted mb-1">Nome da empresa</label>
                <input type="text" name="name" value="{{ old('name', $entity->name) }}" required class="form-control form-control-sm" />
            </div>
            <div>
                <label class="form-label small fw-medium text-muted mb-1">Descrição</label>
                <textarea name="description" rows="3" required class="form-control form-control-sm">{{ old('description', $entity->description) }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Cidade</label>
                    <input type="text" name="location_city" value="{{ old('location_city', $entity->location_city) }}" required class="form-control form-control-sm" />
                </div>
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Distrito</label>
                    <input type="text" name="location_district" value="{{ old('location_district', $entity->location_district) }}" class="form-control form-control-sm" />
                </div>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $entity->phone) }}" class="form-control form-control-sm" />
                </div>
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $entity->whatsapp) }}" class="form-control form-control-sm" />
                </div>
            </div>
            <div>
                <label class="form-label small fw-medium text-muted mb-1">Email público</label>
                <input type="email" name="email" value="{{ old('email', $entity->email) }}" class="form-control form-control-sm" />
            </div>
        </div>

        {{-- Configurações da plataforma --}}
        <div class="card-body p-4 vstack gap-3">
            <h2 class="fw-semibold small text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Configurações da Plataforma</h2>
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Estado de aprovação</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="pending"  {{ old('status', $entity->status) === 'pending'  ? 'selected' : '' }}>Pendente</option>
                        <option value="approved" {{ old('status', $entity->status) === 'approved' ? 'selected' : '' }}>Aprovada</option>
                        <option value="rejected" {{ old('status', $entity->status) === 'rejected' ? 'selected' : '' }}>Rejeitada</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted mb-1">Plano</label>
                    <select name="plan_type" class="form-select form-select-sm">
                        <option value="free"    {{ old('plan_type', $entity->plan_type) === 'free'    ? 'selected' : '' }}>Gratuito</option>
                        <option value="premium" {{ old('plan_type', $entity->plan_type) === 'premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $entity->is_active) ? 'checked' : '' }} />
                    <label class="form-check-label small" for="is_active">Visível na plataforma</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $entity->is_featured) ? 'checked' : '' }} />
                    <label class="form-check-label small" for="is_featured">Em destaque</label>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center p-4">
            <a href="{{ route('admin.entities.index') }}" class="small link-secondary text-decoration-none">Cancelar</a>
            <button class="btn btn-dark btn-sm">Guardar alterações</button>
        </div>
    </form>

    {{-- Produtos da entidade --}}
    @if($entity->products->isNotEmpty())
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h2 class="fw-semibold small mb-0">Produtos / Serviços (últimos 10)</h2>
                <a href="{{ route('entity.show', $entity->slug) }}" target="_blank" class="small link-primary text-decoration-none">Ver perfil público</a>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($entity->products as $product)
                    <li class="list-group-item d-flex align-items-center justify-content-between small gap-3">
                        <div class="min-w-0">
                            <p class="fw-medium text-truncate mb-0">{{ $product->name }}</p>
                            <p class="small text-muted mb-0">{{ ucfirst($product->type) }} · {{ $product->category?->name ?? '—' }}</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-shrink-0">
                            @if($product->price)
                                <span class="small text-muted">{{ number_format($product->price, 2) }} MZN</span>
                            @endif
                            <span class="small {{ $product->is_active ? 'text-success' : 'text-muted' }}">
                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection
