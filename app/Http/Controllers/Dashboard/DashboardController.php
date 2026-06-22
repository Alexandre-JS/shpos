<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $entity = $user->entity;
        if (!$entity) {
            return redirect()->route('home')->with('success', 'Crie uma entidade para aceder ao dashboard.');
        }

        // Contagens de produtos
        $productsCount = $entity->products()->count();
        $activeCount   = $entity->products()->where('is_active', true)->count();
        $servicesCount = $entity->products()->where('type', 'service')->count();
        $productsOnly  = $productsCount - $servicesCount;

        // Visualizações (helper para reutilizar o filtro por entidade)
        $entityViews = fn() => View::whereHas('product', fn($q) => $q->where('entity_id', $entity->id));

        $views24h   = $entityViews()->where('created_at', '>=', now()->subHours(24))->count();
        $views7d    = $entityViews()->where('created_at', '>=', now()->subDays(6)->startOfDay())->count();
        $viewsTotal = $entityViews()->count();

        // Listas
        $recentProducts = $entity->products()->latest()->take(5)->get();
        $topProducts = $entity->products()
            ->where('views_count', '>', 0)
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // Série de visualizações dos últimos 7 dias (agrupada por dia)
        $viewsTimeline = View::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->whereHas('product', fn($q) => $q->where('entity_id', $entity->id))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd');
        $days = collect(range(0, 6))->map(fn($i) => now()->subDays(6 - $i)->format('Y-m-d'));
        $viewsSeries = $days->map(fn($d) => [
            'date' => $d,
            'count' => (int) ($viewsTimeline[$d] ?? 0),
        ]);

        return view('dashboard.index', compact(
            'entity',
            'productsCount',
            'activeCount',
            'servicesCount',
            'productsOnly',
            'views24h',
            'views7d',
            'viewsTotal',
            'recentProducts',
            'topProducts',
            'viewsSeries'
        ));
    }
}
