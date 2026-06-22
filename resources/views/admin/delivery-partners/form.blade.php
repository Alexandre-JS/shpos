@extends('layouts.admin')
@section('header', $partner->exists ? 'Editar Parceiro' : 'Novo Parceiro de Entrega')
@section('nav.delivery', 'active')
@section('content')
<div style="max-width:42rem;">
    <form method="POST"
          action="{{ $partner->exists ? route('admin.delivery-partners.update', $partner) : route('admin.delivery-partners.store') }}"
          class="card"><div class="card-body p-4 vstack gap-4">
        @csrf
        @if ($partner->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-medium mb-1">Nome *</label>
                <input name="name" value="{{ old('name', $partner->name) }}" required class="form-control form-control-sm" />
                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label class="form-label small fw-medium mb-1">Descrição</label>
                <textarea name="description" rows="3" class="form-control form-control-sm" style="resize:none;">{{ old('description', $partner->description) }}</textarea>
                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label small fw-medium mb-1">Telefone</label>
                <input name="phone" value="{{ old('phone', $partner->phone) }}" class="form-control form-control-sm" placeholder="+258 84 000 0000" />
                @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label small fw-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email', $partner->email) }}" class="form-control form-control-sm" />
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label small fw-medium mb-1">Website</label>
                <input name="website" type="url" value="{{ old('website', $partner->website) }}" class="form-control form-control-sm" placeholder="https://" />
                @error('website')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label small fw-medium mb-1">Posição (ordem)</label>
                <input name="position" type="number" min="0" value="{{ old('position', $partner->position ?? 0) }}" class="form-control form-control-sm" />
                @error('position')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label class="form-label small fw-medium mb-1">Áreas de cobertura</label>
                <input name="coverage_areas" value="{{ old('coverage_areas', $partner->coverage_areas) }}" class="form-control form-control-sm" placeholder="Ex: Maputo, Matola, Beira" />
                <p class="text-muted mt-1 mb-0" style="font-size:.625rem;">Cidades ou províncias separadas por vírgula.</p>
                @error('coverage_areas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   @checked(old('is_active', $partner->exists ? $partner->is_active : true)) />
            <label for="is_active" class="form-check-label small">Activo (visível publicamente)</label>
        </div>

        <div class="d-flex justify-content-between pt-2">
            <a href="{{ route('admin.delivery-partners.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
        </div>
    </div></form>
</div>
@endsection
