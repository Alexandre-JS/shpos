@extends('layouts.admin')
@section('title', 'Visão Geral')
@section('header', 'Visão Geral da Plataforma')
@section('nav.admin.dashboard', 'active')

@section('content')

{{-- Cards de estatísticas --}}
<div class="row g-3">
    <div class="col-6 col-md-3">
        <div class="card h-100"><div class="card-body vstack gap-1">
            <p class="small text-muted text-uppercase mb-0">Empresas</p>
            <p class="fs-2 fw-bold mb-0">{{ $stats['entities_total'] }}</p>
            <p class="small text-muted mb-0">{{ $stats['entities_approved'] }} aprovadas · {{ $stats['entities_pending'] }} pendentes</p>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100"><div class="card-body vstack gap-1">
            <p class="small text-muted text-uppercase mb-0">Produtos</p>
            <p class="fs-2 fw-bold mb-0">{{ $stats['products_total'] }}</p>
            <p class="small text-muted mb-0">{{ $stats['products_active'] }} activos</p>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100"><div class="card-body vstack gap-1">
            <p class="small text-muted text-uppercase mb-0">Utilizadores</p>
            <p class="fs-2 fw-bold mb-0">{{ $stats['users_total'] }}</p>
            <p class="small text-muted mb-0">contas registadas</p>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100"><div class="card-body vstack gap-1">
            <p class="small text-muted text-uppercase mb-0">Views (7 dias)</p>
            <p class="fs-2 fw-bold mb-0">{{ $stats['views_7d'] }}</p>
            <p class="small text-muted mb-0">{{ $stats['views_today'] }} hoje</p>
        </div></div>
    </div>
</div>

<div class="row g-4">

    {{-- Pendentes de aprovação --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h2 class="fw-semibold small mb-0">Aguardam Aprovação</h2>
                @if($stats['entities_pending'] > 0)
                    <span class="badge rounded-pill text-bg-warning">{{ $stats['entities_pending'] }}</span>
                @endif
            </div>
            @if($pendingEntities->isEmpty())
                <p class="small text-muted p-3 mb-0">Nenhuma empresa pendente.</p>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($pendingEntities as $entity)
                        <li class="list-group-item d-flex align-items-center justify-content-between gap-3">
                            <div class="min-w-0">
                                <p class="small fw-medium text-truncate mb-0">{{ $entity->name }}</p>
                                <p class="small text-muted mb-0">{{ $entity->user->email }} · {{ $entity->location_city }}</p>
                            </div>
                            <div class="d-flex gap-2 flex-shrink-0">
                                <form method="POST" action="{{ route('admin.entities.approve', $entity) }}" class="m-0">
                                    @csrf @method('PUT')
                                    <button class="btn btn-success btn-sm">Aprovar</button>
                                </form>
                                <a href="{{ route('admin.entities.edit', $entity) }}" class="btn btn-outline-secondary btn-sm">Ver</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if($stats['entities_pending'] > 5)
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.entities.index', ['status' => 'pending']) }}" class="small link-primary text-decoration-none">Ver todas ({{ $stats['entities_pending'] }})</a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Registos recentes --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h2 class="fw-semibold small mb-0">Registos Recentes</h2>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($recentEntities as $entity)
                    <li class="list-group-item d-flex align-items-center justify-content-between gap-3">
                        <div class="min-w-0">
                            <p class="small fw-medium text-truncate mb-0">{{ $entity->name }}</p>
                            <p class="small text-muted mb-0">{{ $entity->created_at->diffForHumans() }}</p>
                        </div>
                        @php $statusBadge = ['pending' => 'text-bg-warning', 'approved' => 'text-bg-success', 'rejected' => 'text-bg-danger'][$entity->status] ?? 'text-bg-secondary'; @endphp
                        <span class="badge {{ $statusBadge }} flex-shrink-0">
                            {{ ['pending' => 'Pendente', 'approved' => 'Aprovada', 'rejected' => 'Rejeitada'][$entity->status] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

{{-- Gráfico simples de views --}}
<div class="card"><div class="card-body">
    <h2 class="fw-semibold small mb-4">Visualizações — últimos 7 dias</h2>
    <div class="d-flex align-items-end gap-2" style="height:6rem;">
        @php $max = max(1, $viewsSeries->max('count')); @endphp
        @foreach($viewsSeries as $day)
            <div class="flex-fill d-flex flex-column align-items-center gap-1">
                <span class="text-muted" style="font-size:.625rem;">{{ $day['count'] }}</span>
                <div class="w-100 bg-dark rounded-top" style="height: {{ max(4, round(($day['count'] / $max) * 80)) }}px"></div>
                <span class="text-muted" style="font-size:.625rem;">{{ $day['date'] }}</span>
            </div>
        @endforeach
    </div>
</div></div>

@endsection
