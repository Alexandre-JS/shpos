@extends('layouts.dashboard')
@section('nav.products', 'bg-gray-100 font-medium')
@section('header', 'Meus Produtos / Serviços')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4 justify-between">
            <div class="flex items-center gap-3 text-sm">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..."
                        class="border rounded px-3 py-2 text-sm" />
                    <select name="type" class="border rounded px-2 py-2 text-sm">
                        <option value="">Todos</option>
                        <option value="product" @selected(request('type') == 'product')>Produtos</option>
                        <option value="service" @selected(request('type') == 'service')>Serviços</option>
                    </select>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Filtrar</button>
                </form>
            </div>
            <a href="{{ route('dashboard.products.create') }}"
                class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Novo</a>
        </div>

        <div class="bg-white border rounded overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="text-left px-4 py-2">Nome</th>
                        <th class="text-left px-4 py-2">Tipo</th>
                        <th class="text-left px-4 py-2">Categoria</th>
                        <th class="text-left px-4 py-2">Preço</th>
                        <th class="text-left px-4 py-2">Ativo</th>
                        <th class="text-left px-4 py-2">Views</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <a href="{{ route('product.show', $p->slug) }}"
                                    class="hover:underline font-medium">{{ $p->name }}</a>
                            </td>
                            <td class="px-4 py-2 text-xs">{{ $p->type === 'product' ? 'Produto' : 'Serviço' }}</td>
                            <td class="px-4 py-2 text-xs">{{ $p->category?->name ?: '—' }}</td>
                            <td class="px-4 py-2 text-xs">{{ $p->price ? 'MT ' . number_format($p->price, 2, ',', '.') : '—' }}
                            </td>
                            <td class="px-4 py-2 text-xs">
                                @if ($p->is_active)
                                <span class="text-green-600">Sim</span>@else<span class="text-gray-400">Não</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs">{{ $p->views_count }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('dashboard.products.edit', $p) }}"
                                    class="text-blue-600 hover:underline text-xs">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-xs text-gray-500">Nenhum item.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t">{{ $products->links() }}</div>
        </div>
    </div>
@endsection
