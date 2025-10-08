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

        $productsCount = $entity->products()->count();
        $views24h = View::whereHas('product', function ($q) use ($entity) {
            $q->where('entity_id', $entity->id);
        })->where('created_at', '>=', now()->subHours(24))->count();

        return view('dashboard.index', compact('entity', 'productsCount', 'views24h'));
    }
}
