@extends('layouts.auth')
@section('title', 'Registar Loja')
@section('auth_width', '52rem')

@section('content')
    <div class="text-center text-white">
        <h1 class="fs-2 fw-bold mb-1">Registar Loja</h1>
        <p class="small text-white-50 mb-0">Crie a sua conta e a vitrine da sua entidade</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex gap-2 mb-0">
            <i class="bi bi-exclamation-circle flex-shrink-0 mt-1"></i>
            <div>
                <p class="fw-semibold small mb-1">Corrija os seguintes campos:</p>
                <ul class="small mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="vstack gap-4">
        @csrf

        {{-- Secção 1: A sua conta --}}
        <div class="card shadow-sm">
            <div class="card-body p-4 vstack gap-3">
                <div class="d-flex align-items-center gap-2 border-bottom pb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-primary flex-shrink-0" style="width:2.25rem;height:2.25rem;background:#fff7ed;"><i class="bi bi-person fs-5"></i></span>
                    <div>
                        <h2 class="fw-bold fs-6 mb-0">A sua conta</h2>
                        <p class="small text-muted mb-0">Dados de acesso ao painel</p>
                    </div>
                </div>

                <div>
                    <label for="name" class="form-label small fw-medium text-muted mb-1">Nome <span class="text-danger">*</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input id="name" name="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="O seu nome completo" />
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="form-label small fw-medium text-muted mb-1">Email <span class="text-danger">*</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror" placeholder="email@exemplo.com" />
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="password" class="form-label small fw-medium text-muted mb-1">Password <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" name="password" required minlength="8" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" />
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePw('password', this)" aria-label="Mostrar password"><i class="bi bi-eye"></i></button>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <p class="form-text small mb-0">Use pelo menos 8 caracteres.</p>
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label small fw-medium text-muted mb-1">Confirmar Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" placeholder="Repita a password" />
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePw('password_confirmation', this)" aria-label="Mostrar password"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secção 2: A sua loja --}}
        <div class="card shadow-sm">
            <div class="card-body p-4 vstack gap-3">
                <div class="d-flex align-items-center gap-2 border-bottom pb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-primary flex-shrink-0" style="width:2.25rem;height:2.25rem;background:#fff7ed;"><i class="bi bi-shop fs-5"></i></span>
                    <div>
                        <h2 class="fw-bold fs-6 mb-0">A sua loja</h2>
                        <p class="small text-muted mb-0">Como os clientes a vão encontrar</p>
                    </div>
                </div>

                <div>
                    <label for="entity_name" class="form-label small fw-medium text-muted mb-1">Nome da Loja <span class="text-danger">*</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-shop-window"></i></span>
                        <input id="entity_name" name="entity_name" value="{{ old('entity_name') }}" required class="form-control @error('entity_name') is-invalid @enderror" placeholder="Ex: Loja da Maria" />
                        @error('entity_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label for="entity_description" class="form-label small fw-medium text-muted mb-1">Descrição <span class="text-danger">*</span></label>
                    <textarea id="entity_description" name="entity_description" rows="3" required class="form-control @error('entity_description') is-invalid @enderror" placeholder="Descreva o que a sua loja vende...">{{ old('entity_description') }}</textarea>
                    @error('entity_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="location_city" class="form-label small fw-medium text-muted mb-1">Cidade <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input id="location_city" name="location_city" value="{{ old('location_city') }}" required class="form-control @error('location_city') is-invalid @enderror" placeholder="Ex: Maputo" />
                            @error('location_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="location_district" class="form-label small fw-medium text-muted mb-1">Bairro</label>
                        <input id="location_district" name="location_district" value="{{ old('location_district') }}" class="form-control @error('location_district') is-invalid @enderror" placeholder="Ex: Sommerschield" />
                        @error('location_district')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="whatsapp" class="form-label small fw-medium text-muted mb-1">WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-whatsapp text-success"></i></span>
                            <input id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required class="form-control @error('whatsapp') is-invalid @enderror" placeholder="258841234567" inputmode="numeric" />
                            @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <p class="form-text small mb-0">Formato: 258 seguido de 9 dígitos.</p>
                    </div>
                    <div class="col-sm-6">
                        <label for="phone" class="form-label small fw-medium text-muted mb-1">Telefone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Opcional" />
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="entity_email" class="form-label small fw-medium text-muted mb-1">Email da Loja</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                            <input id="entity_email" type="email" name="entity_email" value="{{ old('entity_email') }}" class="form-control @error('entity_email') is-invalid @enderror" placeholder="loja@exemplo.com" />
                            @error('entity_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Redes sociais / website (opcional, recolhido) --}}
                @php
                    $hasSocial = old('facebook_url') || old('instagram_url') || old('website_url')
                        || $errors->hasAny(['facebook_url', 'instagram_url', 'website_url']);
                @endphp
                <div>
                    <button class="btn btn-link btn-sm p-0 text-decoration-none d-inline-flex align-items-center gap-1" type="button"
                        data-bs-toggle="collapse" data-bs-target="#socialFields" aria-expanded="{{ $hasSocial ? 'true' : 'false' }}" aria-controls="socialFields">
                        <i class="bi bi-plus-circle"></i> Adicionar redes sociais e website <span class="text-muted">(opcional)</span>
                    </button>
                    <div class="collapse {{ $hasSocial ? 'show' : '' }}" id="socialFields">
                        <div class="row g-3 pt-3">
                            <div class="col-sm-6">
                                <label for="facebook_url" class="form-label small fw-medium text-muted mb-1">Facebook</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-facebook text-primary"></i></span>
                                    <input id="facebook_url" name="facebook_url" value="{{ old('facebook_url') }}" class="form-control @error('facebook_url') is-invalid @enderror" placeholder="https://facebook.com/..." />
                                    @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="instagram_url" class="form-label small fw-medium text-muted mb-1">Instagram</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-instagram text-danger"></i></span>
                                    <input id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}" class="form-control @error('instagram_url') is-invalid @enderror" placeholder="https://instagram.com/..." />
                                    @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="website_url" class="form-label small fw-medium text-muted mb-1">Website</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input id="website_url" name="website_url" value="{{ old('website_url') }}" class="form-control @error('website_url') is-invalid @enderror" placeholder="https://..." />
                                    @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rodapé: nota + acções --}}
        <div class="card shadow-sm">
            <div class="card-body p-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <p class="small text-muted mb-0 d-flex align-items-start gap-2">
                    <i class="bi bi-clock-history mt-1"></i>
                    <span>A sua loja será revista e aprovada em <strong>24–48 horas</strong>.</span>
                </p>
                <div class="d-flex align-items-center gap-3 flex-shrink-0">
                    <a href="{{ route('home') }}" class="small link-secondary text-decoration-none">Cancelar</a>
                    <button class="btn btn-primary fw-semibold px-4"><i class="bi bi-check2-circle me-1"></i>Criar Loja</button>
                </div>
            </div>
        </div>

        <p class="text-center small text-white-50 mb-0">
            Já tem conta? <a href="{{ route('login.show') }}" class="text-white fw-medium">Entrar</a>
        </p>
    </form>
@endsection

@push('scripts')
<script>
    function togglePw(id, btn) {
        const el = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (el.type === 'password') {
            el.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            el.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endpush
