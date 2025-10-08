@extends('layouts.dashboard')
@section('nav.stats', 'bg-gray-100 font-medium')
@section('header', 'Estatísticas')
@section('content')
    <div class="space-y-10" x-data='{"series": @json($viewsSeries)}'>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="p-5 bg-white rounded border space-y-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Produtos</h3>
                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                <p class="text-xs text-gray-400">Itens do tipo produto</p>
            </div>
            <div class="p-5 bg-white rounded border space-y-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Serviços</h3>
                <p class="text-3xl font-bold">{{ $totalServices }}</p>
                <p class="text-xs text-gray-400">Itens do tipo serviço</p>
            </div>
            <div class="p-5 bg-white rounded border space-y-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ativos</h3>
                <p class="text-3xl font-bold">{{ $totalActive }}</p>
                <p class="text-xs text-gray-400">Publicados</p>
            </div>
            <div class="p-5 bg-white rounded border space-y-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Novos (7d)</h3>
                <p class="text-3xl font-bold">{{ $recentLast7 }}</p>
                <p class="text-xs text-gray-400">Adicionados últimos 7 dias</p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 p-5 bg-white rounded border space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold">Views últimos 7 dias</h3>
                    <span class="text-xs text-gray-500">24h: {{ $views24h }} • 7d: {{ $views7d }}</span>
                </div>
                <div class="h-40 flex items-end gap-2" x-init>
                    <template x-for="pt in series" :key="pt.date">
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-gradient-to-t from-primary/20 to-primary rounded"
                                :style="'height:' + (pt.count === 0 ? 4 : (pt.count * 12 + 8)) + 'px'" title=""
                                x-tooltip="pt.count + ' views'">
                            </div>
                            <span class="text-[10px] text-gray-500" x-text="pt.date.slice(5)"></span>
                        </div>
                    </template>
                </div>
            </div>
            <div class="p-5 bg-white rounded border space-y-4">
                <h3 class="text-sm font-semibold">Top 5 mais vistos</h3>
                <ul class="divide-y text-sm">
                    @forelse($topViewed as $p)
                        <li class="py-2 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('product.show', $p->slug) }}"
                                    class="font-medium hover:underline truncate-2">{{ $p->name }}</a>
                                <div class="text-[10px] text-gray-500 uppercase">
                                    {{ $p->type === 'product' ? 'Produto' : 'Serviço' }}</div>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">{{ $p->views_count }}</span>
                        </li>
                    @empty
                        <li class="py-4 text-xs text-gray-500">Sem dados.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="p-5 bg-white rounded border space-y-4">
            <h3 class="text-sm font-semibold">Distribuição por Categoria</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase">
                        <tr>
                            <th class="text-left px-3 py-2">Categoria</th>
                            <th class="text-left px-3 py-2">Total</th>
                            <th class="text-left px-3 py-2">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand = max(1, $byCategory->sum('total')); @endphp
                        @forelse($byCategory as $row)
                            <tr class="border-t">
                                <td class="px-3 py-2 text-gray-700 text-xs">{{ $row->category?->name ?? '—' }}</td>
                                <td class="px-3 py-2 text-gray-700 text-xs">{{ $row->total }}</td>
                                <td class="px-3 py-2 text-gray-700 text-xs">
                                    {{ number_format(($row->total / $grand) * 100, 1) }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-6 text-center text-xs text-gray-500">Sem dados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
