@extends('layouts.dashboard')
@section('nav.products', 'bg-gray-100 font-medium')
@section('header', 'Editar Produto / Serviço')
@section('content')
    <div class="max-w-3xl space-y-6">
        <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="bg-white border rounded p-6 space-y-5">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border rounded px-3 py-2 text-sm" required />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Categoria</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Selecionar --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Tipo *</label>
                    <select name="type" class="w-full border rounded px-3 py-2 text-sm" required>
                        <option value="product" @selected(old('type', $product->type) == 'product')>Produto</option>
                        <option value="service" @selected(old('type', $product->type) == 'service')>Serviço</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Preço (opcional)</label>
                    <input name="price" value="{{ old('price', $product->price) }}" type="number" step="0.01"
                        min="0" class="w-full border rounded px-3 py-2 text-sm" />
                    @error('price')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Tipo de Desconto</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Nenhum --</option>
                        <option value="percent" @selected(old('discount_type', $product->discount_type) === 'percent')>Percentual (%)</option>
                        <option value="amount" @selected(old('discount_type', $product->discount_type) === 'amount')>Valor Fixo</option>
                    </select>
                    @error('discount_type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Valor do Desconto</label>
                    <input name="discount_value" value="{{ old('discount_value', $product->discount_value) }}"
                        type="number" step="0.01" min="0" class="w-full border rounded px-3 py-2 text-sm" />
                    <p class="text-[10px] text-gray-500">Percent: 0-100. Valor: mesma moeda do preço.</p>
                    @error('discount_value')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Início do Desconto</label>
                    <input name="discount_starts_at"
                        value="{{ old('discount_starts_at', optional($product->discount_starts_at)->format('Y-m-d\TH:i')) }}"
                        type="datetime-local" class="w-full border rounded px-3 py-2 text-sm" />
                    @error('discount_starts_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Fim do Desconto</label>
                    <input name="discount_ends_at"
                        value="{{ old('discount_ends_at', optional($product->discount_ends_at)->format('Y-m-d\TH:i')) }}"
                        type="datetime-local" class="w-full border rounded px-3 py-2 text-sm" />
                    @error('discount_ends_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Descrição</label>
                <textarea name="description" rows="5" required class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
            <div class="space-y-4"
                x-data='multiImagesEdit({
                    existing: @json($existingImages),
                    reorderUrl: "{{ route('dashboard.products.images.reorder', $product) }}",
                    csrf: "{{ csrf_token() }}"
                })'>
                <div>
                    <label class="block text-xs font-medium mb-1">Imagens atuais</label>
                    <template x-if="existing.length">
                        <div class="flex flex-wrap gap-2" @dragover.prevent>
                            <template x-for="(img,i) in existing" :key="img.id">
                                <div class="relative w-20 h-20" draggable="true" @dragstart="dragStart(i,$event)"
                                    @drop.prevent="drop(i,$event)" @dragover.prevent
                                    :class="draggingIndex === i ? 'opacity-40' : ''">
                                    <label class="block w-full h-full border rounded overflow-hidden cursor-move group">
                                        <input type="radio" class="absolute inset-0 opacity-0 cursor-pointer"
                                            name="primary_existing_id" :value="img.id" :checked="img.is_primary" />
                                        <img :src="img.path" alt="img"
                                            class="object-cover w-full h-full group-hover:scale-105 transition-transform" />
                                        <span class="absolute top-0 left-0 bg-black/40 text-[9px] px-1 text-white">#<span
                                                x-text="i+1"></span></span>
                                        <span
                                            class="absolute bottom-0 inset-x-0 text-[10px] bg-black/50 text-white text-center"
                                            x-text="img.is_primary ? 'Principal' : 'Marcar'"></span>
                                    </label>
                                </div>
                            </template>
                        </div>
                    </template>
                    <p class="text-[10px] text-gray-500 mt-1">Arraste para reordenar. Seleciona para definir principal.</p>
                    <template x-if="reorderStatus">
                        <p class="text-[10px]" :class="reorderStatus === 'Salvo' ? 'text-green-600' : 'text-gray-500'"
                            x-text="'Ordem: '+reorderStatus"></p>
                    </template>
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-medium mb-1">Adicionar novas (até 8)</label>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm" @change="handleSelect($event)" />
                    <input type="hidden" name="primary_image_index" :value="primaryIndex" />
                    <p class="text-[10px] text-gray-500">Clique numa nova miniatura para tornar principal (irá substituir
                        seleção acima).</p>
                    <template x-if="previews.length">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(p,i) in previews" :key="i">
                                <button type="button" @click="selectPrimary(i)"
                                    class="relative w-20 h-20 border rounded overflow-hidden focus:outline-none"
                                    :class="primaryIndex === i ? 'ring-2 ring-blue-500 border-blue-500' : 'border-gray-200'">
                                    <img :src="p" class="object-cover w-full h-full" />
                                    <span class="absolute bottom-0 inset-x-0 text-[10px] bg-black/50 text-white"
                                        x-text="primaryIndex===i ? 'Principal' : ''"></span>
                                </button>
                            </template>
                        </div>
                    </template>
                    @error('images')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <details class="text-xs text-gray-500">
                    <summary class="cursor-pointer select-none">Compatibilidade antiga (uma imagem)</summary>
                    <div class="pt-2 space-y-2">
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                            class="w-full text-sm" />
                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </details>
            </div>
            <div class="flex items-center gap-3">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) /> Ativo
                </label>
            </div>
            <div class="flex justify-between pt-4">
                <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST"
                    onsubmit="return confirm('Remover este item?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 text-sm border rounded text-red-600">Remover</button>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard.products.index') }}"
                        class="px-4 py-2 text-sm border rounded">Cancelar</a>
                    <button class="px-5 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
                </div>
            </div>
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
