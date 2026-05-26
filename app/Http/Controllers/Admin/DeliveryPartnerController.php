<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartner;
use Illuminate\Http\Request;

class DeliveryPartnerController extends Controller
{
    public function index()
    {
        $partners = DeliveryPartner::orderBy('position')->orderBy('name')->get();
        return view('admin.delivery-partners.index', compact('partners'));
    }

    public function create()
    {
        $partner = new DeliveryPartner();
        return view('admin.delivery-partners.form', compact('partner'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:120',
            'description'    => 'nullable|string|max:500',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:120',
            'website'        => 'nullable|url|max:200',
            'coverage_areas' => 'nullable|string|max:200',
            'is_active'      => 'boolean',
            'position'       => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        DeliveryPartner::create($data);

        return redirect()->route('admin.delivery-partners.index')
            ->with('success', 'Parceiro criado com sucesso.');
    }

    public function edit(DeliveryPartner $deliveryPartner)
    {
        $partner = $deliveryPartner;
        return view('admin.delivery-partners.form', compact('partner'));
    }

    public function update(Request $request, DeliveryPartner $deliveryPartner)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:120',
            'description'    => 'nullable|string|max:500',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:120',
            'website'        => 'nullable|url|max:200',
            'coverage_areas' => 'nullable|string|max:200',
            'is_active'      => 'boolean',
            'position'       => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $deliveryPartner->update($data);

        return redirect()->route('admin.delivery-partners.index')
            ->with('success', 'Parceiro actualizado.');
    }

    public function toggleActive(DeliveryPartner $deliveryPartner)
    {
        $deliveryPartner->update(['is_active' => !$deliveryPartner->is_active]);
        return back()->with('success', 'Estado actualizado.');
    }

    public function destroy(DeliveryPartner $deliveryPartner)
    {
        $deliveryPartner->delete();
        return redirect()->route('admin.delivery-partners.index')
            ->with('success', 'Parceiro removido.');
    }
}
