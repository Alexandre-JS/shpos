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
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Descrição</label>
                <textarea name="description" rows="5" class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-medium mb-1">Imagem (substituir)</label>
                @if ($product->image_path)
                    <div
                        class="w-32 aspect-square bg-gray-100 flex items-center justify-center overflow-hidden rounded border">
                        <img src="/{{ $product->image_path }}" alt="preview" class="object-cover w-full h-full" />
                    </div>
                @endif
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full text-sm" />
                <p class="text-[10px] text-gray-500">Deixa vazio para manter a atual.</p>
                @error('image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
                    <a href="{{ route('dashboard.products.index') }}" class="px-4 py-2 text-sm border rounded">Cancelar</a>
                    <button class="px-5 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
