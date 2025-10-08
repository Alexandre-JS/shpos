<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EntityUpdateRequest;
use App\Services\ImageUploadService;

class EntitySettingsController extends Controller
{
    public function edit(Request $request)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');
        return view('dashboard.entity.settings', compact('entity'));
    }

    public function update(EntityUpdateRequest $request, ImageUploadService $uploader)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            if ($entity->logo_path) {
                $uploader->delete($entity->logo_path);
            }
            $data['logo_path'] = $uploader->upload($request->file('logo'), 'uploads/entities');
        }
        $entity->update($data);

        return redirect()->route('dashboard.entity.settings.edit')->with('success', 'Entidade atualizada.');
    }
}
