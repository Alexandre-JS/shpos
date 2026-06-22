@extends('layouts.dashboard')
@section('nav.products', 'active')
@section('header', 'Meus Produtos / Serviços')
@section('content')
    <div class="vstack gap-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 justify-content-between">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..." class="form-control form-control-sm" />
                <select name="type" class="form-select form-select-sm w-auto">
                    <option value="">Todos</option>
                    <option value="product" @selected(request('type') == 'product')>Produtos</option>
                    <option value="service" @selected(request('type') == 'service')>Serviços</option>
                </select>
                <button class="btn btn-dark btn-sm">Filtrar</button>
            </form>
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm">Novo</a>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead class="table-light text-uppercase text-muted" style="font-size:.75rem;">
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Ativo</th>
                            <th>Views</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td><a href="{{ route('product.show', $p->publicRouteParameters()) }}" class="fw-medium link-body-emphasis text-decoration-none">{{ $p->name }}</a></td>
                                <td>{{ $p->type === 'product' ? 'Produto' : 'Serviço' }}</td>
                                <td>{{ $p->category?->name ?: '—' }}</td>
                                <td>{{ $p->price ? 'MT ' . number_format($p->price, 2, ',', '.') : '—' }}</td>
                                <td>
                                    @if ($p->is_active)
                                    <span class="text-success">Sim</span>@else<span class="text-muted">Não</span>
                                    @endif
                                </td>
                                <td>{{ $p->views_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('dashboard.products.edit', $p) }}" class="link-primary text-decoration-none">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-muted">Nenhum item.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3 border-top">{{ $products->links() }}</div>
        </div>
    </div>
@endsection
