@extends('layouts.app')
@section('title', 'Entidades')
@section('content')
    <x-app-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 order-2 lg:order-1">
                {{-- Reutiliza sidebar (necessário passar dados) --}}
                @php
                    $categories = \App\Models\Category::active()
                        ->withCount([
                            'products as items_count' => function ($q) {
                                $q->active();
                            },
                        ])
                        ->orderByDesc('items_count')
                        ->orderBy('name')
                        ->get();
                    $sidebarEntities = $entities->getCollection();
                @endphp
                <x-sidebar-lists :categories="$categories" :entities="$sidebarEntities" />
            </div>
            <div class="lg:col-span-3 order-1 lg:order-2 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="space-y-1">
                        <h1 class="text-2xl font-bold">Entidades</h1>
                        <p class="text-xs text-gray-500">Total: {{ $entities->total() }} entidades</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <form method="GET" class="flex gap-2 items-center">
                            <input type="hidden" name="sort" value="{{ $sort }}" />
                            <input type="text" name="q" value="{{ $q }}"
                                placeholder="Buscar entidade..." class="input input-bordered w-56" />
                            <button class="btn btn-primary btn-sm">Pesquisar</button>
                        </form>
                        <form method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="q" value="{{ $q }}" />
                            <label class="text-xs text-gray-500">Ordenar</label>
                            <select name="sort" class="select select-bordered select-sm" onchange="this.form.submit()">
                                <option value="itens" @selected($sort === 'itens')>Mais Itens</option>
                                <option value="recent" @selected($sort === 'recent')>Mais Recentes</option>
                                <option value="nome" @selected($sort === 'nome')>Nome (A-Z)</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($entities as $e)
                        <a href="{{ route('entity.show', $e->slug) }}"
                            class="border rounded p-4 bg-white hover:shadow-sm transition flex flex-col gap-2">
                            <h3 class="font-medium text-sm leading-tight line-clamp-2">{{ $e->name }}</h3>
                            <div class="text-[11px] text-gray-500">{{ $e->location_city }} {{ $e->location_district }}</div>
                            <div class="flex items-center justify-between text-xs mt-auto">
                                <span class="inline-flex items-center gap-1"><span
                                        class="w-2 h-2 rounded-full bg-green-500"></span>Ativa</span>
                                <span class="text-gray-600 font-semibold">{{ $e->items_count }} itens</span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-sm text-gray-500">Nenhuma entidade encontrada.</div>
                    @endforelse
                </div>
                <div>
                    {{ $entities->links() }}
                </div>
            </div>
        </div>
    </x-app-container>
@endsection
