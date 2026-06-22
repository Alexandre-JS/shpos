@extends('layouts.dashboard')
@section('nav.stats', 'active')
@section('header', 'Estatísticas')
@section('content')
    <div class="vstack gap-4">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="card h-100"><div class="card-body vstack gap-1">
                    <h3 class="small fw-semibold text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Produtos</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $totalProducts }}</p>
                    <p class="small text-muted mb-0">Itens do tipo produto</p>
                </div></div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100"><div class="card-body vstack gap-1">
                    <h3 class="small fw-semibold text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Serviços</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $totalServices }}</p>
                    <p class="small text-muted mb-0">Itens do tipo serviço</p>
                </div></div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100"><div class="card-body vstack gap-1">
                    <h3 class="small fw-semibold text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Ativos</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $totalActive }}</p>
                    <p class="small text-muted mb-0">Publicados</p>
                </div></div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100"><div class="card-body vstack gap-1">
                    <h3 class="small fw-semibold text-muted text-uppercase mb-0" style="letter-spacing:.05em;">Novos (7d)</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $recentLast7 }}</p>
                    <p class="small text-muted mb-0">Adicionados últimos 7 dias</p>
                </div></div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="card h-100"><div class="card-body vstack gap-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="small fw-semibold mb-0">Views últimos 7 dias</h3>
                        <span class="small text-muted">24h: {{ $views24h }} • 7d: {{ $views7d }}</span>
                    </div>
                    @php $maxViews = max(1, $viewsSeries->max('count')); @endphp
                    <div class="d-flex align-items-end gap-2" style="height:10rem;">
                        @foreach ($viewsSeries as $pt)
                            <div class="flex-fill d-flex flex-column align-items-center gap-1" title="{{ $pt['count'] }} views">
                                <span class="text-muted" style="font-size:.625rem;">{{ $pt['count'] }}</span>
                                <div class="w-100 bg-primary rounded-top" style="height: {{ max(4, round(($pt['count'] / $maxViews) * 120)) }}px"></div>
                                <span class="text-muted" style="font-size:.625rem;">{{ substr($pt['date'], 5) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div></div>
            </div>
            <div class="col-md-4">
                <div class="card h-100"><div class="card-body vstack gap-3">
                    <h3 class="small fw-semibold mb-0">Top 5 mais vistos</h3>
                    <ul class="list-group list-group-flush small">
                        @forelse($topViewed as $p)
                            <li class="list-group-item px-0 d-flex align-items-center justify-content-between gap-3">
                                <div class="min-w-0">
                                    <a href="{{ route('product.show', $p->publicRouteParameters()) }}" class="fw-medium link-body-emphasis text-decoration-none truncate-2">{{ $p->name }}</a>
                                    <div class="text-muted text-uppercase" style="font-size:.625rem;">{{ $p->type === 'product' ? 'Produto' : 'Serviço' }}</div>
                                </div>
                                <span class="small fw-semibold text-muted">{{ $p->views_count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 small text-muted">Sem dados.</li>
                        @endforelse
                    </ul>
                </div></div>
            </div>
        </div>

        <div class="card"><div class="card-body vstack gap-3">
            <h3 class="small fw-semibold mb-0">Distribuição por Categoria</h3>
            <div class="table-responsive">
                <table class="table table-sm small mb-0">
                    <thead class="table-light text-uppercase text-muted">
                        <tr>
                            <th>Categoria</th>
                            <th>Total</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand = max(1, $byCategory->sum('total')); @endphp
                        @forelse($byCategory as $row)
                            <tr>
                                <td>{{ $row->category?->name ?? '—' }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ number_format(($row->total / $grand) * 100, 1) }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Sem dados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div></div>
    </div>
@endsection
