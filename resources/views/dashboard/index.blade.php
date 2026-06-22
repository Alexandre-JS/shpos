@extends('layouts.dashboard')
@section('nav.dashboard', 'active')
@section('header', 'Visão Geral')
@section('content')

    {{-- Banner de estado pendente --}}
    @if ($entity->isPending())
        <div class="alert alert-warning d-flex align-items-start gap-3 mb-0">
            <i class="bi bi-exclamation-triangle fs-5 flex-shrink-0"></i>
            <div>
                <p class="fw-semibold mb-1">Registo a aguardar aprovação</p>
                <p class="small mb-0">
                    O teu perfil está em revisão. Assim que for aprovado, o teu negócio ficará visível publicamente e poderás gerir produtos e serviços.
                    Entretanto, podes completar as <a href="{{ route('dashboard.entity.settings.edit') }}" class="fw-medium">definições da tua entidade</a>.
                </p>
            </div>
        </div>
    @endif

    {{-- KPIs --}}
    <div class="row g-3">
        <div class="col-6 col-lg-3">
            <div class="card h-100"><div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="small fw-semibold text-muted text-uppercase mb-1" style="letter-spacing:.05em;">Produtos</p>
                    <p class="fs-3 fw-bold mb-0">{{ $productsCount }}</p>
                    <p class="small text-muted mb-0">{{ $productsOnly }} produto(s) · {{ $servicesCount }} serviço(s)</p>
                </div>
                <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-primary flex-shrink-0" style="width:2.75rem;height:2.75rem;background:#fff7ed;"><i class="bi bi-box-seam fs-5"></i></span>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100"><div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="small fw-semibold text-muted text-uppercase mb-1" style="letter-spacing:.05em;">Ativos</p>
                    <p class="fs-3 fw-bold mb-0">{{ $activeCount }}</p>
                    <p class="small text-muted mb-0">de {{ $productsCount }} publicáveis</p>
                </div>
                <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-success flex-shrink-0" style="width:2.75rem;height:2.75rem;background:#f0fdf4;"><i class="bi bi-check2-circle fs-5"></i></span>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100"><div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="small fw-semibold text-muted text-uppercase mb-1" style="letter-spacing:.05em;">Views (7 dias)</p>
                    <p class="fs-3 fw-bold mb-0">{{ $views7d }}</p>
                    <p class="small text-muted mb-0">{{ $views24h }} nas últimas 24h</p>
                </div>
                <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-primary flex-shrink-0" style="width:2.75rem;height:2.75rem;background:#fff7ed;"><i class="bi bi-eye fs-5"></i></span>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100"><div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="small fw-semibold text-muted text-uppercase mb-1" style="letter-spacing:.05em;">Views (total)</p>
                    <p class="fs-3 fw-bold mb-0">{{ $viewsTotal }}</p>
                    <p class="small text-muted mb-0">desde sempre</p>
                </div>
                <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-secondary flex-shrink-0" style="width:2.75rem;height:2.75rem;background:#fff7ed;"><i class="bi bi-graph-up fs-5"></i></span>
            </div></div>
        </div>
    </div>

    @if ($productsCount === 0)
        {{-- Estado vazio: ainda sem produtos --}}
        <div class="card"><div class="card-body text-center py-5">
            <div class="display-6 mb-2">📦</div>
            <h2 class="fs-5 fw-bold mb-1">Ainda não tem produtos</h2>
            <p class="small text-muted mb-3" style="max-width:28rem;margin-inline:auto;">
                Comece por adicionar o seu primeiro produto ou serviço para aparecer na plataforma.
            </p>
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Adicionar primeiro produto</a>
        </div></div>
    @endif

    <div class="row g-4">
        {{-- Gráfico de visualizações --}}
        <div class="col-lg-8">
            <div class="card h-100"><div class="card-body vstack gap-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="fs-6 fw-bold mb-0">Visualizações — últimos 7 dias</h2>
                    <a href="{{ route('dashboard.stats') }}" class="small link-primary text-decoration-none">Ver estatísticas</a>
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

        {{-- Ações rápidas + estado --}}
        <div class="col-lg-4">
            <div class="card h-100"><div class="card-body vstack gap-3">
                <h2 class="fs-6 fw-bold mb-0">Ações rápidas</h2>
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Novo produto</a>
                    <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-seam me-1"></i>Gerir produtos</a>
                    <a href="{{ route('dashboard.entity.settings.edit') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-shop me-1"></i>Editar loja</a>
                    <a href="{{ route('entity.show', $entity->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Ver loja pública</a>
                </div>
                <hr class="my-1" />
                <div class="d-flex align-items-center justify-content-between small">
                    <span class="text-muted">Estado da loja</span>
                    @php
                        $statusMap = [
                            'pending'  => ['Pendente', 'text-bg-warning'],
                            'approved' => ['Aprovada', 'text-bg-success'],
                            'rejected' => ['Rejeitada', 'text-bg-danger'],
                        ];
                        [$statusLabel, $statusClass] = $statusMap[$entity->status] ?? ['—', 'text-bg-secondary'];
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between small">
                    <span class="text-muted">Plano</span>
                    <span class="fw-medium">{{ ucfirst($entity->plan_type ?? 'free') }}</span>
                </div>
            </div></div>
        </div>
    </div>

    @if ($productsCount > 0)
    <div class="row g-4">
        {{-- Produtos recentes --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex align-items-center justify-content-between">
                    <h2 class="fs-6 fw-bold mb-0">Produtos recentes</h2>
                    <a href="{{ route('dashboard.products.index') }}" class="small link-primary text-decoration-none">Ver todos</a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($recentProducts as $p)
                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('dashboard.products.edit', $p) }}" class="fw-medium small link-body-emphasis text-decoration-none text-truncate d-block">{{ $p->name }}</a>
                                <span class="small text-muted">{{ $p->type === 'product' ? 'Produto' : 'Serviço' }} · {{ $p->created_at->diffForHumans() }}</span>
                            </div>
                            <span class="badge text-bg-light flex-shrink-0">{{ $p->is_active ? 'Ativo' : 'Inativo' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Mais vistos --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex align-items-center justify-content-between">
                    <h2 class="fs-6 fw-bold mb-0">Mais vistos</h2>
                    <a href="{{ route('dashboard.stats') }}" class="small link-primary text-decoration-none">Estatísticas</a>
                </div>
                @if ($topProducts->isEmpty())
                    <div class="card-body small text-muted">Ainda sem visualizações registadas.</div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($topProducts as $p)
                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3">
                                <a href="{{ route('product.show', $p->publicRouteParameters()) }}" target="_blank" class="fw-medium small link-body-emphasis text-decoration-none text-truncate">{{ $p->name }}</a>
                                <span class="small fw-semibold text-muted flex-shrink-0"><i class="bi bi-eye me-1"></i>{{ $p->views_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    @endif
@endsection
