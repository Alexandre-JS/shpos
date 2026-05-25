<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Product;
use App\Models\User;
use App\Models\View;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'entities_total'    => Entity::count(),
            'entities_pending'  => Entity::where('status', 'pending')->count(),
            'entities_approved' => Entity::where('status', 'approved')->count(),
            'entities_rejected' => Entity::where('status', 'rejected')->count(),
            'products_total'    => Product::count(),
            'products_active'   => Product::where('is_active', true)->count(),
            'users_total'       => User::count(),
            'views_today'       => View::whereDate('created_at', today())->count(),
            'views_7d'          => View::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $pendingEntities = Entity::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $recentEntities = Entity::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // Views por dia nos últimos 7 dias
        $viewsTimeline = View::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd');

        $days = collect(range(0, 6))->map(fn($i) => now()->subDays(6 - $i)->format('Y-m-d'));
        $viewsSeries = $days->map(fn($d) => [
            'date'  => \Carbon\Carbon::parse($d)->format('d/m'),
            'count' => (int) ($viewsTimeline[$d] ?? 0),
        ]);

        return view('admin.dashboard', compact('stats', 'pendingEntities', 'recentEntities', 'viewsSeries'));
    }
}
