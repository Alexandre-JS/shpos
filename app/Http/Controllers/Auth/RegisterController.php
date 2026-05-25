<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntityRegistrationRequest;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(EntityRegistrationRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            // Gerar slug básico (service dedicado virá depois)
            $baseSlug = Str::slug($data['entity_name']);
            $slug = $baseSlug;
            $counter = 2;
            while (Entity::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            Entity::create([
                'user_id'           => $user->id,
                'name'              => $data['entity_name'],
                'slug'              => $slug,
                'description'       => $data['entity_description'],
                'location_city'     => $data['location_city'],
                'location_district' => $data['location_district'] ?? null,
                'phone'             => $data['phone'] ?? null,
                'whatsapp'          => $data['whatsapp'],
                'email'             => $data['entity_email'] ?? null,
                'facebook_url'      => $data['facebook_url'] ?? null,
                'instagram_url'     => $data['instagram_url'] ?? null,
                'website_url'       => $data['website_url'] ?? null,
                'status'            => 'pending',
            ]);

            Auth::login($user);
            DB::commit();

            return redirect()->route('dashboard.index')
                ->with('info', 'Conta criada! O teu registo está a aguardar aprovação. Receberás uma notificação quando estiver activo.');
        } catch (\Throwable) {
            DB::rollBack();
            return back()->withErrors(['general' => 'Erro ao registrar.'])->withInput();
        }
    }
}
