@extends('layouts.dashboard')
@section('nav.products', 'active')
@section('header', 'Editar Produto / Serviço')
@section('content')
    <div style="max-width:48rem;">
        <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="card"><div class="card-body p-4 vstack gap-4">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name', $product->name) }}" class="form-control form-control-sm" required />
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1" for="category_id">Categoria *</label>
                    <select id="category_id" name="category_id" class="form-select form-select-sm @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Selecionar --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @error('category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Tipo *</label>
                    <select name="type" class="form-select form-select-sm" required>
                        <option value="product" @selected(old('type', $product->type) == 'product')>Produto</option>
                        <option value="service" @selected(old('type', $product->type) == 'service')>Serviço</option>
                    </select>
                    @error('type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Preço (opcional)</label>
                    <input name="price" value="{{ old('price', $product->price) }}" type="number" step="0.01" min="0" class="form-control form-control-sm" />
                    @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Tipo de Desconto</label>
                    <select name="discount_type" class="form-select form-select-sm">
                        <option value="">-- Nenhum --</option>
                        <option value="percent" @selected(old('discount_type', $product->discount_type) === 'percent')>Percentual (%)</option>
                        <option value="amount" @selected(old('discount_type', $product->discount_type) === 'amount')>Valor Fixo</option>
                    </select>
                    @error('discount_type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Valor do Desconto</label>
                    <input name="discount_value" value="{{ old('discount_value', $product->discount_value) }}" type="number" step="0.01" min="0" class="form-control form-control-sm" />
                    <p class="text-muted mb-0 mt-1" style="font-size:.625rem;">Percent: 0-100. Valor: mesma moeda do preço.</p>
                    @error('discount_value')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Início do Desconto</label>
                    <input name="discount_starts_at"
                        value="{{ old('discount_starts_at', optional($product->discount_starts_at)->format('Y-m-d\TH:i')) }}"
                        type="datetime-local" class="form-control form-control-sm" />
                    @error('discount_starts_at')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium mb-1">Fim do Desconto</label>
                    <input name="discount_ends_at"
                        value="{{ old('discount_ends_at', optional($product->discount_ends_at)->format('Y-m-d\TH:i')) }}"
                        type="datetime-local" class="form-control form-control-sm" />
                    @error('discount_ends_at')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div>
                <label class="form-label small fw-medium mb-1">Descrição</label>
                <textarea name="description" rows="5" required class="form-control form-control-sm">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            @php
                $existingImages = $product->images->map(function ($im) {
                    return [
                        'id' => $im->id,
                        'path' => asset($im->path),
                        'is_primary' => $im->is_primary,
                    ];
                });
            @endphp
            <div class="vstack gap-3"
                x-data='multiImagesEdit({
                    existing: @json($existingImages),
                    reorderUrl: "{{ route('dashboard.products.images.reorder', $product) }}",
                    csrf: "{{ csrf_token() }}"
                })'>
                <div>
                    <label class="form-label small fw-medium mb-1">Imagens atuais</label>
                    <template x-if="existing.length">
                        <div class="d-flex flex-wrap gap-2" @dragover.prevent>
                            <template x-for="(img,i) in existing" :key="img.id">
                                <div class="position-relative" style="width:5rem;height:5rem;" draggable="true" @dragstart="dragStart(i,$event)"
                                    @drop.prevent="drop(i,$event)" @dragover.prevent
                                    :class="draggingIndex === i ? 'opacity-50' : ''">
                                    <label class="d-block w-100 h-100 border rounded overflow-hidden" style="cursor:move;">
                                        <input type="radio" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor:pointer;"
                                            name="primary_existing_id" :value="img.id" :checked="img.is_primary" />
                                        <img :src="img.path" alt="img" class="object-fit-cover w-100 h-100" />
                                        <span class="position-absolute top-0 start-0 text-white px-1" style="font-size:.5625rem;background:rgba(0,0,0,.4);">#<span x-text="i+1"></span></span>
                                        <span class="position-absolute bottom-0 start-0 end-0 text-white text-center" style="font-size:.625rem;background:rgba(0,0,0,.5);"
                                            x-text="img.is_primary ? 'Principal' : 'Marcar'"></span>
                                    </label>
                                </div>
                            </template>
                        </div>
                    </template>
                    <p class="text-muted mt-1 mb-0" style="font-size:.625rem;">Arraste para reordenar. Seleciona para definir principal.</p>
                    <template x-if="reorderStatus">
                        <p style="font-size:.625rem;" :class="reorderStatus === 'Salvo' ? 'text-success' : 'text-muted'"
                            x-text="'Ordem: '+reorderStatus"></p>
                    </template>
                </div>
                <div class="vstack gap-2">
                    <label class="form-label small fw-medium mb-1">Adicionar novas (até 8)</label>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                        class="form-control form-control-sm" @change="handleSelect($event)" />
                    <input type="hidden" name="primary_image_index" :value="primaryIndex" />
                    <p class="text-muted mb-0" style="font-size:.625rem;">Clique numa nova miniatura para tornar principal (irá substituir seleção acima).</p>
                    <template x-if="previews.length">
                        <div class="d-flex flex-wrap gap-2">
                            <template x-for="(p,i) in previews" :key="i">
                                <button type="button" @click="selectPrimary(i)"
                                    class="position-relative border rounded overflow-hidden p-0 bg-transparent" style="width:5rem;height:5rem;"
                                    :class="primaryIndex === i ? 'border-primary border-2' : 'border-secondary-subtle'">
                                    <img :src="p" class="object-fit-cover w-100 h-100" />
                                    <span class="position-absolute bottom-0 start-0 end-0 text-white" style="font-size:.625rem;background:rgba(0,0,0,.5);"
                                        x-text="primaryIndex===i ? 'Principal' : ''"></span>
                                </button>
                            </template>
                        </div>
                    </template>
                    @error('images')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    @error('images.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <details class="small text-muted">
                    <summary class="user-select-none" style="cursor:pointer;">Compatibilidade antiga (uma imagem)</summary>
                    <div class="pt-2 vstack gap-2">
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="form-control form-control-sm" />
                        @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </details>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $product->is_active)) />
                    <label class="form-check-label small" for="is_active">Ativo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="has_delivery" id="has_delivery" value="1" @checked(old('has_delivery', $product->has_delivery)) />
                    <label class="form-check-label small" for="has_delivery">Entrega disponível</label>
                </div>
            </div>
            <div class="d-flex justify-content-between pt-2">
                <button form="deleteProductForm" class="btn btn-outline-danger btn-sm">Remover</button>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                    <button class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </div>
        </div></form>
        <form id="deleteProductForm" action="{{ route('dashboard.products.destroy', $product) }}" method="POST"
            onsubmit="return confirm('Remover este item?');" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function multiImagesEdit(cfg) {
            return {
                existing: cfg.existing || [],
                previews: [],
                primaryIndex: null,
                draggingIndex: null,
                reorderUrl: cfg.reorderUrl,
                csrf: cfg.csrf,
                reorderStatus: '',
                handleSelect(e) {
                    this.previews = [];
                    const files = Array.from(e.target.files || []);
                    files.slice(0, 8).forEach((f, idx) => {
                        const reader = new FileReader();
                        reader.onload = ev => {
                            this.previews[idx] = ev.target.result;
                        };
                        reader.readAsDataURL(f);
                    });
                    if (files.length) {
                        document.querySelectorAll('input[name="primary_existing_id"]').forEach(el => el.checked = false);
                        this.primaryIndex = 0;
                    }
                },
                selectPrimary(i) {
                    this.primaryIndex = i;
                    document.querySelectorAll('input[name="primary_existing_id"]').forEach(el => el.checked = false);
                },
                dragStart(i, ev) {
                    this.draggingIndex = i;
                    ev.dataTransfer.effectAllowed = 'move';
                },
                drop(i, ev) {
                    if (this.draggingIndex === null || this.draggingIndex === i) {
                        this.draggingIndex = null;
                        return;
                    }
                    const item = this.existing.splice(this.draggingIndex, 1)[0];
                    this.existing.splice(i, 0, item);
                    this.draggingIndex = null;
                    this.sendReorder();
                },
                sendReorder() {
                    const order = this.existing.map(im => im.id);
                    this.reorderStatus = 'a enviar...';
                    fetch(this.reorderUrl, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order
                            })
                        }).then(r => r.json()).then(() => {
                            this.reorderStatus = 'Salvo';
                            setTimeout(() => this.reorderStatus = '', 3000);
                        })
                        .catch(() => {
                            this.reorderStatus = 'Erro';
                            setTimeout(() => this.reorderStatus = '', 4000);
                        });
                }
            }
        }
    </script>
@endpush
