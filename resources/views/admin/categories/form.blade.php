@extends('layouts.admin')
@section('title', $category->exists ? 'Editar Categoria' : 'Nova Categoria')
@section('header', $category->exists ? 'Editar Categoria' : 'Nova Categoria')
@section('nav.admin.categories', 'bg-gray-800 text-white')

@section('content')
<div class="max-w-lg">

    <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
        <a href="{{ route('admin.categories.index') }}" class="hover:underline">Categorias</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">{{ $category->exists ? $category->name : 'Nova' }}</span>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-3 rounded text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="bg-white rounded border divide-y">
        @csrf
        @if($category->exists) @method('PUT') @endif

        <div class="p-5 space-y-4">
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-600">Nome</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Tipo</label>
                    <select name="type" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <option value="both"    {{ old('type', $category->type) === 'both'    ? 'selected' : '' }}>Produtos e Serviços</option>
                        <option value="product" {{ old('type', $category->type) === 'product' ? 'selected' : '' }}>Só Produtos</option>
                        <option value="service" {{ old('type', $category->type) === 'service' ? 'selected' : '' }}>Só Serviços</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Ícone (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" maxlength="10"
                           placeholder="Ex: 🛒"
                           class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $category->exists ? $category->is_active : true) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300" />
                Activa (visível na plataforma)
            </label>
        </div>

        <div class="p-5 flex justify-between items-center">
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:underline">Cancelar</a>
            <button class="bg-gray-900 text-white px-5 py-2 rounded text-sm hover:bg-gray-700">
                {{ $category->exists ? 'Guardar alterações' : 'Criar categoria' }}
            </button>
        </div>
    </form>
</div>
@endsection
