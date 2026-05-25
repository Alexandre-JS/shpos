@extends('layouts.admin')
@section('title', 'Categorias')
@section('header', 'Categorias')
@section('nav.admin.categories', 'bg-gray-800 text-white')

@section('content')
<div class="flex justify-end">
    <a href="{{ route('admin.categories.create') }}"
       class="bg-gray-900 text-white text-sm px-4 py-2 rounded hover:bg-gray-700">
        + Nova categoria
    </a>
</div>

<div class="bg-white rounded border">
    @if($categories->isEmpty())
        <p class="text-sm text-gray-400 p-6 text-center">Nenhuma categoria criada.</p>
    @else
        <div class="divide-y">
            @foreach($categories as $cat)
                <div class="p-4 flex items-center gap-4">
                    <div class="text-2xl w-8 text-center shrink-0">{{ $cat->icon ?? '—' }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-medium">{{ $cat->name }}</p>
                            <span class="text-xs border rounded px-1.5 py-0.5 text-gray-500">
                                {{ ['product' => 'Produto', 'service' => 'Serviço', 'both' => 'Ambos'][$cat->type] }}
                            </span>
                            @if(!$cat->is_active)
                                <span class="text-xs bg-gray-200 text-gray-500 rounded px-1.5 py-0.5">Inactiva</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $cat->products_count }} produto(s) · slug: {{ $cat->slug }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0 text-xs">
                        <a href="{{ route('admin.categories.edit', $cat) }}"
                           class="border rounded px-3 py-1.5 hover:bg-gray-50">Editar</a>

                        <form method="POST" action="{{ route('admin.categories.toggle', $cat) }}">
                            @csrf @method('PUT')
                            <button class="{{ $cat->is_active ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded px-3 py-1.5">
                                {{ $cat->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white rounded px-3 py-1.5 hover:bg-red-700
                                {{ $cat->products_count > 0 ? 'opacity-40 cursor-not-allowed' : '' }}"
                                {{ $cat->products_count > 0 ? 'disabled' : '' }}
                                onclick="{{ $cat->products_count > 0 ? 'return false' : "return confirm('Eliminar «{$cat->name}»?')" }}">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
