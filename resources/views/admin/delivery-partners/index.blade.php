@extends('layouts.admin')
@section('header', 'Parceiros de Entrega')
@section('nav.delivery', 'bg-indigo-900 text-white font-medium')
@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $partners->count() }} parceiro(s) registado(s)</p>
        <a href="{{ route('admin.delivery-partners.create') }}" class="btn btn-primary btn-sm">+ Novo parceiro</a>
    </div>

    @if ($partners->isEmpty())
        <div class="bg-white border rounded p-10 text-center text-gray-400">
            <p class="text-sm">Nenhum parceiro registado.</p>
        </div>
    @else
        <div class="bg-white border rounded overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-left">
                        <th class="px-4 py-3 font-medium text-gray-600">#</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Nome</th>
                        <th class="px-4 py-3 font-medium text-gray-600 hidden sm:table-cell">Cobertura</th>
                        <th class="px-4 py-3 font-medium text-gray-600 hidden md:table-cell">Contacto</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Estado</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($partners as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $p->position }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">{{ $p->name }}</div>
                                @if ($p->description)
                                    <div class="text-xs text-gray-400 truncate max-w-xs">{{ $p->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 hidden sm:table-cell text-xs">{{ $p->coverage_areas ?: '—' }}</td>
                            <td class="px-4 py-3 hidden md:table-cell text-xs text-gray-500">
                                @if($p->phone) <div>{{ $p->phone }}</div> @endif
                                @if($p->email) <div>{{ $p->email }}</div> @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($p->is_active)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-neutral">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('admin.delivery-partners.edit', $p) }}"
                                       class="text-xs text-indigo-600 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('admin.delivery-partners.toggle', $p) }}" class="inline">
                                        @csrf @method('PUT')
                                        <button class="text-xs text-gray-500 hover:underline">
                                            {{ $p->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.delivery-partners.destroy', $p) }}" class="inline"
                                          onsubmit="return confirm('Remover este parceiro?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-500 hover:underline">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
