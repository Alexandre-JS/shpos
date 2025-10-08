<?php

namespace App\Http\Controllers;

use App\Models\Entity;

class EntityController extends Controller
{
    public function show(Entity $entity)
    {
        abort_unless($entity->is_active, 404);
        $entity->load(['products' => function ($q) {
            $q->active()->orderByDesc('created_at');
        }]);
        return view('entities.show', compact('entity'));
    }
}
