@extends('layouts.admin')
@section('title', 'Visão Geral')
@section('header', 'Visão Geral da Plataforma')
@section('nav.admin.dashboard', 'bg-gray-800 text-white')

@section('content')

{{-- Cards de estatísticas --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded border p-4 space-y-1">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Empresas</p>
        <p class="text-3xl font-bold">{{ $stats['entities_total'] }}</p>
        <p class="text-xs text-gray-400">{{ $stats['entities_approved'] }} aprovadas · {{ $stats['entities_pending'] }} pendentes</p>
    </div>
    <div class="bg-white rounded border p-4 space-y-1">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Produtos</p>
        <p class="text-3xl font-bold">{{ $stats['products_total'] }}</p>
        <p class="text-xs text-gray-400">{{ $stats['products_active'] }} activos</p>
    </div>
    <div class="bg-white rounded border p-4 space-y-1">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Utilizadores</p>
        <p class="text-3xl font-bold">{{ $stats['users_total'] }}</p>
        <p class="text-xs text-gray-400">contas registadas</p>
    </div>
    <div class="bg-white rounded border p-4 space-y-1">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Views (7 dias)</p>
        <p class="text-3xl font-bold">{{ $stats['views_7d'] }}</p>
        <p class="text-xs text-gray-400">{{ $stats['views_today'] }} hoje</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">

    {{-- Pendentes de aprovação --}}
    <div class="bg-white rounded border">
        <div class="px-4 py-3 border-b flex items-center justify-between">
            <h2 class="font-semibold text-sm">Aguardam Aprovação</h2>
            @if($stats['entities_pending'] > 0)
                <span class="bg-amber-100 text-amber-700 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $stats['entities_pending'] }}
                </span>
            @endif
        </div>
        @if($pendingEntities->isEmpty())
            <p class="text-sm text-gray-400 p-4">Nenhuma empresa pendente.</p>
        @else
            <div class="divide-y">
                @foreach($pendingEntities as $entity)
                    <div class="px-4 py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate">{{ $entity->name }}</p>
                            <p class="text-xs text-gray-400">{{ $entity->user->email }} · {{ $entity->location_city }}</p>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.entities.approve', $entity) }}">
                                @csrf @method('PUT')
                                <button class="text-xs bg-green-600 text-white px-2.5 py-1 rounded hover:bg-green-700">Aprovar</button>
                            </form>
                            <a href="{{ route('admin.entities.edit', $entity) }}"
                               class="text-xs border rounded px-2.5 py-1 hover:bg-gray-50">Ver</a>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($stats['entities_pending'] > 5)
                <div class="px-4 py-2 border-t">
                    <a href="{{ route('admin.entities.index', ['status' => 'pending']) }}"
                       class="text-xs text-blue-600 hover:underline">Ver todas ({{ $stats['entities_pending'] }})</a>
                </div>
            @endif
        @endif
    </div>

    {{-- Registos recentes --}}
    <div class="bg-white rounded border">
        <div class="px-4 py-3 border-b">
            <h2 class="font-semibold text-sm">Registos Recentes</h2>
        </div>
        <div class="divide-y">
            @foreach($recentEntities as $entity)
                <div class="px-4 py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate">{{ $entity->name }}</p>
                        <p class="text-xs text-gray-400">{{ $entity->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs px-1.5 py-0.5 rounded shrink-0
                        {{ $entity->status === 'pending'  ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $entity->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $entity->status === 'rejected' ? 'bg-red-100 text-red-700'     : '' }}">
                        {{ ['pending' => 'Pendente', 'approved' => 'Aprovada', 'rejected' => 'Rejeitada'][$entity->status] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Gráfico simples de views --}}
<div class="bg-white rounded border p-4">
    <h2 class="font-semibold text-sm mb-4">Visualizações — últimos 7 dias</h2>
    <div class="flex items-end gap-2 h-24">
        @php $max = max(1, $viewsSeries->max('count')); @endphp
        @foreach($viewsSeries as $day)
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] text-gray-500">{{ $day['count'] }}</span>
                <div class="w-full bg-gray-800 rounded-t"
                     style="height: {{ max(4, round(($day['count'] / $max) * 80)) }}px"></div>
                <span class="text-[10px] text-gray-400">{{ $day['date'] }}</span>
            </div>
        @endforeach
    </div>
</div>

@endsection
