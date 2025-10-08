<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $entity = $request->user()->entity;
        if (!$entity) {
            return redirect()->route('dashboard.index');
        }

        // Totais básicos
        $totalProducts = $entity->products()->where('type', 'product')->count();
        $totalServices = $entity->products()->where('type', 'service')->count();
        $totalActive = $entity->products()->where('is_active', true)->count();

        // Novos últimos 7 dias
        $recentLast7 = $entity->products()->where('created_at', '>=', now()->subDays(7))->count();

        // Views últimas 24h & 7 dias
        $views24h = View::whereHas('product', fn($q) => $q->where('entity_id', $entity->id))
            ->where('created_at', '>=', now()->subHours(24))->count();
        $views7d = View::whereHas('product', fn($q) => $q->where('entity_id', $entity->id))
            ->where('created_at', '>=', now()->subDays(7))->count();

        // Top 5 mais vistos
        $topViewed = Product::where('entity_id', $entity->id)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get(['id', 'name', 'views_count', 'slug', 'type']);

        // Distribuição por categoria
        $byCategory = Product::selectRaw('category_id, COUNT(*) as total')
            ->where('entity_id', $entity->id)
            ->groupBy('category_id')
            ->with('category:id,name')
            ->orderByDesc('total')
            ->get();

        // Timeline simples de views últimos 7 dias (agrupando em dia)
        $viewsTimeline = View::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->whereHas('product', fn($q) => $q->where('entity_id', $entity->id))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd');

        $days = collect(range(0, 6))->map(fn($i) => now()->subDays(6 - $i)->format('Y-m-d'));
        $viewsSeries = $days->map(fn($d) => [
            'date' => $d,
            'count' => (int)($viewsTimeline[$d] ?? 0)
        ]);

        return view('dashboard.stats.index', compact(
            'entity',
            'totalProducts',
            'totalServices',
            'totalActive',
            'recentLast7',
            'views24h',
            'views7d',
            'topViewed',
            'byCategory',
            'viewsSeries'
        ));
    }
}
