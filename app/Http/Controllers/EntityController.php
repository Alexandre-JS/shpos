<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $sort = $request->get('sort', 'itens'); // itens | recent | nome
        $entitiesQuery = Entity::active()
            ->withCount(['products as items_count' => fn($p) => $p->active()]);
        if ($q !== '') {
            $entitiesQuery->where('name', 'like', "%{$q}%");
        }
        switch ($sort) {
            case 'recent':
                $entitiesQuery->orderByDesc('last_item_at')->orderBy('name');
                break;
            case 'nome':
                $entitiesQuery->orderBy('name');
                break;
            case 'itens':
            default:
                $entitiesQuery->orderByDesc('items_count')->orderBy('name');
                $sort = 'itens';
        }
        $entities = $entitiesQuery->paginate(30)->appends(['q' => $q, 'sort' => $sort]);

        return view('entities.index', compact('entities', 'q', 'sort'));
    }
    public function show(Entity $entity)
    {
        abort_unless($entity->is_active, 404);
        $entity->load(['products' => function ($q) {
            $q->active()->orderByDesc('created_at');
        }]);
        return view('entities.show', compact('entity'));
    }
}
