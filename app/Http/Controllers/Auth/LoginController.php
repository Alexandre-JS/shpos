<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user   = Auth::user();
            $entity = $user->entity;

            // Loja desactivada pelo admin
            if (!$user->is_admin && $entity && $entity->isApproved() && !$entity->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'A tua loja foi temporariamente desactivada. Contacta o suporte para mais informações.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            $destination = $user->is_admin ? route('admin.dashboard') : route('dashboard.index');
            return redirect()->intended($destination);
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
