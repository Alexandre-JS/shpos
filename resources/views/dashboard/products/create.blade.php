@extends('layouts.dashboard')
@section('nav.products', 'bg-gray-100 font-medium')
@section('header', 'Novo Produto / Serviço')
@section('content')
    <div class="max-w-3xl space-y-6">
        <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border rounded p-6 space-y-5">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 text-sm"
                        required />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Categoria</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Selecionar --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Tipo *</label>
                    <select name="type" class="w-full border rounded px-3 py-2 text-sm" required>
                        <option value="product" @selected(old('type') == 'product')>Produto</option>
                        <option value="service" @selected(old('type') == 'service')>Serviço</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Preço (opcional)</label>
                    <input name="price" value="{{ old('price') }}" type="number" step="0.01" min="0"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('price')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Tipo de Desconto</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Nenhum --</option>
                        <option value="percent" @selected(old('discount_type') === 'percent')>Percentual (%)</option>
                        <option value="amount" @selected(old('discount_type') === 'amount')>Valor Fixo</option>
                    </select>
                    @error('discount_type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Valor do Desconto</label>
                    <input name="discount_value" value="{{ old('discount_value') }}" type="number" step="0.01"
                        min="0" class="w-full border rounded px-3 py-2 text-sm" />
                    <p class="text-[10px] text-gray-500">Percent: 0-100. Valor: mesma moeda do preço.</p>
                    @error('discount_value')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Início do Desconto</label>
                    <input name="discount_starts_at" value="{{ old('discount_starts_at') }}" type="datetime-local"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('discount_starts_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Fim do Desconto</label>
                    <input name="discount_ends_at" value="{{ old('discount_ends_at') }}" type="datetime-local"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('discount_ends_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Descrição</label>
                <textarea name="description" rows="5" required class="w-full border rounded px-3 py-2 text-sm">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div x-data="multiImagesCreate()" class="space-y-2">
                <label class="block text-xs font-medium mb-1">Imagens (até 8)</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                    class="w-full text-sm" @change="handleSelect($event)" />
                <input type="hidden" name="primary_image_index" :value="primaryIndex" />
                <p class="text-[10px] text-gray-500">Selecione várias. Clique numa miniatura para definir como principal.
                </p>
                <template x-if="previews.length">
                    <div class="flex flex-wrap gap-2 pt-1">
                        <template x-for="(p,i) in previews" :key="i">
                            <button type="button" @click="primaryIndex=i"
                                class="relative w-20 h-20 border rounded overflow-hidden focus:outline-none"
                                :class="primaryIndex === i ? 'ring-2 ring-blue-500 border-blue-500' : 'border-gray-200'">
                                <img :src="p" alt="preview" class="object-cover w-full h-full" />
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
            <div class="flex items-center gap-5">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) /> Ativo
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="has_delivery" value="1" @checked(old('has_delivery', false)) />
                    <span>Entrega disponível</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('dashboard.products.index') }}" class="px-4 py-2 text-sm border rounded">Cancelar</a>
                <button class="px-5 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            </div>
        </form>
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
