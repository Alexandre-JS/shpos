@extends('layouts.admin')
@section('title', 'Empresas / Lojas')
@section('header', 'Empresas e Lojas')
@section('nav.admin.entities', 'bg-gray-800 text-white')

@section('content')

{{-- Tabs de estado --}}
<div class="flex gap-1 text-sm">
    @foreach(['pending' => 'Pendentes', 'approved' => 'Aprovadas', 'rejected' => 'Rejeitadas'] as $s => $label)
        <a href="{{ route('admin.entities.index', ['status' => $s, 'q' => $q]) }}"
           class="px-4 py-2 rounded-t border-b-2 font-medium
               {{ $status === $s
                   ? 'border-gray-900 text-gray-900 bg-white'
                   : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-white' }}">
            {{ $label }}
            @if($counts[$s] > 0)
                <span class="ml-1 text-xs {{ $s === 'pending' ? 'text-amber-600 font-bold' : 'text-gray-400' }}">
                    ({{ $counts[$s] }})
                </span>
            @endif
        </a>
    @endforeach
</div>

<div class="bg-white rounded border -mt-px">

    {{-- Barra de pesquisa --}}
    <div class="p-3 border-b">
        <form method="GET" action="{{ route('admin.entities.index') }}" class="flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}" />
            <input type="text" name="q" value="{{ $q }}"
                   placeholder="Pesquisar por nome ou cidade..."
                   class="flex-1 border rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
            <button class="px-3 py-1.5 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">Pesquisar</button>
            @if($q)
                <a href="{{ route('admin.entities.index', ['status' => $status]) }}"
                   class="px-3 py-1.5 border text-sm rounded hover:bg-gray-50">Limpar</a>
            @endif
        </form>
    </div>

    @if($entities->isEmpty())
        <p class="text-sm text-gray-400 p-6 text-center">Nenhuma empresa encontrada.</p>
    @else
        <div class="divide-y">
            @foreach($entities as $entity)
                <div class="p-4 flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-semibold">{{ $entity->name }}</p>
                            @if($entity->is_featured)
                                <span class="text-[10px] bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded">Destaque</span>
                            @endif
                            @if(!$entity->is_active && $entity->status === 'approved')
                                <span class="text-[10px] bg-gray-200 text-gray-600 px-1.5 py-0.5 rounded">Desactivada</span>
                            @endif
                            <span class="text-[10px] border px-1.5 py-0.5 rounded text-gray-500">{{ ucfirst($entity->plan_type) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $entity->user->email }} &bull; {{ $entity->location_city }}
                            @if($entity->location_district) · {{ $entity->location_district }} @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $entity->products_count }} produto(s) &bull; Registado {{ $entity->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2 shrink-0 text-xs">
                        <a href="{{ route('admin.entities.edit', $entity) }}"
                           class="border rounded px-3 py-1.5 hover:bg-gray-50">Editar</a>
                        <a href="{{ route('entity.show', $entity->slug) }}" target="_blank"
                           class="border rounded px-3 py-1.5 hover:bg-gray-50">Ver perfil</a>

                        @if($entity->status !== 'approved')
                            <form method="POST" action="{{ route('admin.entities.approve', $entity) }}">
                                @csrf @method('PUT')
                                <button class="bg-green-600 text-white rounded px-3 py-1.5 hover:bg-green-700">Aprovar</button>
                            </form>
                        @endif
                        @if($entity->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.entities.reject', $entity) }}">
                                @csrf @method('PUT')
                                <button class="bg-orange-500 text-white rounded px-3 py-1.5 hover:bg-orange-600"
                                    onclick="return confirm('Rejeitar «{{ $entity->name }}»?')">Rejeitar</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.entities.toggle', $entity) }}">
                            @csrf @method('PUT')
                            <button class="{{ $entity->is_active ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded px-3 py-1.5">
                                {{ $entity->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.entities.destroy', $entity) }}">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white rounded px-3 py-1.5 hover:bg-red-700"
                                onclick="return confirm('Eliminar permanentemente «{{ $entity->name }}»? Esta acção não pode ser revertida.')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="p-3 border-t">{{ $entities->links() }}</div>
    @endif
</div>
@endsection
