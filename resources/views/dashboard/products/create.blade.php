@extends('layouts.dashboard')
@section('nav.products', 'active')
@section('header', 'Novo Produto / Serviço')
@section('content')
    <div style="max-width:48rem;">
        <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data"
            class="card"><div class="card-body p-4 vstack gap-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name') }}" class="form-control form-control-sm @error('name') is-invalid @enderror" required />
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1" for="category_id">Categoria *</label>
                    <select id="category_id" name="category_id" class="form-select form-select-sm @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Selecionar --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @error('category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Tipo *</label>
                    <select name="type" class="form-select form-select-sm" required>
                        <option value="product" @selected(old('type') == 'product')>Produto</option>
                        <option value="service" @selected(old('type') == 'service')>Serviço</option>
                    </select>
                    @error('type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Preço (opcional)</label>
                    <input name="price" value="{{ old('price') }}" type="number" step="0.01" min="0" class="form-control form-control-sm" />
                    @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Tipo de Desconto</label>
                    <select name="discount_type" class="form-select form-select-sm">
                        <option value="">-- Nenhum --</option>
                        <option value="percent" @selected(old('discount_type') === 'percent')>Percentual (%)</option>
                        <option value="amount" @selected(old('discount_type') === 'amount')>Valor Fixo</option>
                    </select>
                    @error('discount_type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Valor do Desconto</label>
                    <input name="discount_value" value="{{ old('discount_value') }}" type="number" step="0.01" min="0" class="form-control form-control-sm" />
                    <p class="text-muted mb-0 mt-1" style="font-size:.625rem;">Percent: 0-100. Valor: mesma moeda do preço.</p>
                    @error('discount_value')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Início do Desconto</label>
                    <input name="discount_starts_at" value="{{ old('discount_starts_at') }}" type="datetime-local" class="form-control form-control-sm" />
                    @error('discount_starts_at')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Fim do Desconto</label>
                    <input name="discount_ends_at" value="{{ old('discount_ends_at') }}" type="datetime-local" class="form-control form-control-sm" />
                    @error('discount_ends_at')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div>
                <label class="form-label small fw-medium mb-1">Descrição</label>
                <textarea name="description" rows="5" required class="form-control form-control-sm">{{ old('description') }}</textarea>
                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div x-data="multiImagesCreate()" class="vstack gap-2">
                <label class="form-label small fw-medium mb-1">Imagens (até 8)</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                    class="form-control form-control-sm" @change="handleSelect($event)" />
                <input type="hidden" name="primary_image_index" :value="primaryIndex" />
                <p class="text-muted mb-0" style="font-size:.625rem;">Selecione várias. Clique numa miniatura para definir como principal.</p>
                <template x-if="previews.length">
                    <div class="d-flex flex-wrap gap-2 pt-1">
                        <template x-for="(p,i) in previews" :key="i">
                            <button type="button" @click="primaryIndex=i"
                                class="position-relative border rounded overflow-hidden p-0 bg-transparent" style="width:5rem;height:5rem;"
                                :class="primaryIndex === i ? 'border-primary border-2' : 'border-secondary-subtle'">
                                <img :src="p" alt="preview" class="object-fit-cover w-100 h-100" />
                                <span class="position-absolute bottom-0 start-0 end-0 text-white" style="font-size:.625rem;background:rgba(0,0,0,.5);"
                                    x-text="primaryIndex===i ? 'Principal' : ''"></span>
                            </button>
                        </template>
                    </div>
                </template>
                @error('images')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                @error('images.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true)) />
                    <label class="form-check-label small" for="is_active">Ativo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="has_delivery" id="has_delivery" value="1" @checked(old('has_delivery', false)) />
                    <label class="form-check-label small" for="has_delivery">Entrega disponível</label>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2">
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                <button class="btn btn-primary btn-sm">Salvar</button>
            </div>
        </div></form>
    </div>
@endsection

@push('scripts')
    <script>
        function multiImagesCreate() {
            return {
                previews: [],
                primaryIndex: 0,
                handleSelect(e) {
                    this.previews = [];
                    const files = Array.from(e.target.files || []);
                    files.slice(0, 8).forEach((f, idx) => {
                        const reader = new FileReader();
                        reader.onload = ev => {
                            this.previews[idx] = ev.target.result;
                        }; // reactive
                        reader.readAsDataURL(f);
                    });
                    if (this.primaryIndex >= files.length) {
                        this.primaryIndex = 0;
                    }
                }
            }
        }
    </script>
@endpush
