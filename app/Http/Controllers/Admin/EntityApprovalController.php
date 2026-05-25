<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;


class EntityApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $q      = trim($request->get('q', ''));

        $entities = Entity::with('user')
            ->withCount('products')
            ->when(in_array($status, ['pending', 'approved', 'rejected']), fn($query) => $query->where('status', $status))
            ->when($q, fn($query) => $query->where('name', 'like', "%{$q}%")
                ->orWhere('location_city', 'like', "%{$q}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'pending'  => Entity::where('status', 'pending')->count(),
            'approved' => Entity::where('status', 'approved')->count(),
            'rejected' => Entity::where('status', 'rejected')->count(),
        ];

        return view('admin.entities.index', compact('entities', 'status', 'q', 'counts'));
    }

    public function edit(Entity $entity)
    {
        $entity->load(['user', 'products' => fn($q) => $q->latest()->limit(10)]);
        return view('admin.entities.edit', compact('entity'));
    }

    public function update(Request $request, Entity $entity)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'location_city'     => 'required|string|max:100',
            'location_district' => 'nullable|string|max:100',
            'phone'             => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:255',
            'status'            => 'required|in:pending,approved,rejected',
            'is_active'         => 'boolean',
            'is_featured'       => 'boolean',
            'plan_type'         => 'required|in:free,premium',
        ]);

        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $entity->update($data);

        return redirect()->route('admin.entities.index')
            ->with('success', "Entidade «{$entity->name}» actualizada.");
    }

    public function approve(Entity $entity)
    {
        $entity->update(['status' => 'approved', 'is_active' => true]);
        return back()->with('success', "«{$entity->name}» aprovada.");
    }

    public function reject(Entity $entity)
    {
        $entity->update(['status' => 'rejected', 'is_active' => false]);
        return back()->with('success', "«{$entity->name}» rejeitada.");
    }

    public function toggleActive(Entity $entity)
    {
        $newState = !$entity->is_active;
        $entity->update(['is_active' => $newState]);

        // Cascata: activar/desactivar todos os produtos da loja
        $entity->products()->update(['is_active' => $newState]);

        $label = $newState ? 'activada (e todos os seus produtos)' : 'desactivada (e todos os seus produtos)';
        return back()->with('success', "«{$entity->name}» {$label}.");
    }

    public function destroy(Entity $entity)
    {
        $name = $entity->name;
        $entity->delete();
        return redirect()->route('admin.entities.index')
            ->with('success', "Entidade «{$name}» eliminada.");
    }
}
