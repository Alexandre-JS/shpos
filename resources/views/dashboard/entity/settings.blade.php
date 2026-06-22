@extends('layouts.dashboard')
@section('nav.entity', 'active')
@section('header', 'Configurações da Entidade')
@section('content')
    <div style="max-width:56rem;">
        <form action="{{ route('dashboard.entity.settings.update') }}" method="POST" enctype="multipart/form-data"
            class="card"><div class="card-body p-4 vstack gap-4">
            @if (session('success'))
                <div class="alert alert-success small mb-0">{{ session('success') }}</div>
            @endif
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name', $entity->name) }}" required class="form-control form-control-sm" />
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Email</label>
                    <input name="email" value="{{ old('email', $entity->email) }}" class="form-control form-control-sm" />
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Telefone</label>
                    <input name="phone" value="{{ old('phone', $entity->phone) }}" class="form-control form-control-sm" />
                    @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">WhatsApp (258XXXXXXXXX)</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $entity->whatsapp) }}" class="form-control form-control-sm" />
                    @error('whatsapp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Cidade</label>
                    <input name="location_city" value="{{ old('location_city', $entity->location_city) }}" class="form-control form-control-sm" />
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Distrito / Província</label>
                    <input name="location_district" value="{{ old('location_district', $entity->location_district) }}" class="form-control form-control-sm" />
                </div>
            </div>
            <div>
                <label class="form-label small fw-medium mb-1">Descrição *</label>
                <textarea name="description" rows="6" class="form-control form-control-sm" required>{{ old('description', $entity->description) }}</textarea>
                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-medium mb-1">Instagram URL</label>
                    <input name="instagram_url" value="{{ old('instagram_url', $entity->instagram_url) }}" class="form-control form-control-sm" />
                    @error('instagram_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-medium mb-1">Facebook URL</label>
                    <input name="facebook_url" value="{{ old('facebook_url', $entity->facebook_url) }}" class="form-control form-control-sm" />
                    @error('facebook_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-medium mb-1">Website URL</label>
                    <input name="website_url" value="{{ old('website_url', $entity->website_url) }}" class="form-control form-control-sm" />
                    @error('website_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="vstack gap-2">
                <label class="form-label small fw-medium mb-1">Logotipo</label>
                @if ($entity->logo_path)
                    <div class="bg-light d-flex align-items-center justify-content-center overflow-hidden rounded border" style="width:7rem;height:7rem;">
                        <img src="/{{ $entity->logo_path }}" alt="logo" class="object-fit-cover w-100 h-100" />
                    </div>
                @endif
                <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="form-control form-control-sm" />
                <p class="text-muted mb-0" style="font-size:.625rem;">Formatos: JPG, PNG, WebP até 2MB.</p>
                @error('logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2">
                <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
                <button class="btn btn-primary btn-sm">Salvar</button>
            </div>
        </div></form>
    </div>
@endsection
