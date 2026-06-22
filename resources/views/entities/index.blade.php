@extends('layouts.app')
@section('title', 'Empresas e Lojas')
@section('meta_description', 'Explore todas as empresas e lojas registadas em ' . config('app.name', 'Vitrine') . '. Encontre um negócio perto de si.')
@section('content')
    <x-app-container class="py-4">
        <div class="row g-4">
            <div class="col-lg-3 order-2 order-lg-1">
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

            <div class="col-lg-9 order-1 order-lg-2 vstack gap-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                    <div>
                        <h1 class="fs-3 fw-bold mb-1">Lojas e Empresas</h1>
                        <p class="small text-muted mb-0">{{ $entities->total() }} entidades registadas</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <form method="GET" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="sort" value="{{ $sort }}" />
                            <input type="text" name="q" value="{{ $q }}"
                                placeholder="Buscar entidade..." class="form-control form-control-sm" style="width:13rem;" />
                            <button class="btn btn-primary btn-sm">Pesquisar</button>
                        </form>
                        <form method="GET" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="q" value="{{ $q }}" />
                            <label class="small text-muted mb-0">Ordenar</label>
                            <select name="sort" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="itens" @selected($sort === 'itens')>Mais Itens</option>
                                <option value="recent" @selected($sort === 'recent')>Mais Recentes</option>
                                <option value="nome" @selected($sort === 'nome')>Nome (A-Z)</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @forelse($entities as $e)
                        <div class="col"><x-entity-card :entity="$e" /></div>
                    @empty
                        <div class="col-12">
                            <x-empty icon="🏪" title="Nenhuma entidade encontrada" subtitle="Tente ajustar a pesquisa." />
                        </div>
                    @endforelse
                </div>

                <div>
                    {{ $entities->links() }}
                </div>
            </div>
        </div>
    </x-app-container>
@endsection
