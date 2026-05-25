<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureEntityOwner
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        Log::debug('EnsureEntityOwner:enter', [
            'user_id' => $user?->id,
            'has_entity' => (bool) ($user?->entity),
            'route' => $request->route()?->getName(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);
        if (!$user) {
            Log::warning('EnsureEntityOwner:unauthenticated', ['path' => $request->path()]);
            throw new AccessDeniedHttpException('Requer autenticação.');
        }

        // Admins não precisam de ter entidade — têm a sua própria área
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        if (!$user->entity) {
            Log::warning('EnsureEntityOwner:missing-entity', ['user_id' => $user->id]);
            throw new AccessDeniedHttpException('Crie uma entidade para continuar.');
        }

        // Loja desactivada pelo admin — forçar logout mesmo com sessão activa
        if ($user->entity->isApproved() && !$user->entity->is_active) {
            Log::warning('EnsureEntityOwner:deactivated', ['user_id' => $user->id, 'entity_id' => $user->entity->id]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login.show')
                ->withErrors(['email' => 'A tua loja foi temporariamente desactivada. Contacta o suporte para mais informações.']);
        }

        // Entidades rejeitadas não acedem ao dashboard
        if ($user->entity->isRejected()) {
            Log::warning('EnsureEntityOwner:rejected', ['user_id' => $user->id, 'entity_id' => $user->entity->id]);
            Auth::logout();
            return redirect()->route('login.show')
                ->withErrors(['email' => 'O teu registo foi rejeitado. Contacta o suporte para mais informações.']);
        }

        // Entidades pendentes só acedem ao dashboard (índice e definições) — bloqueadas noutras rotas
        if ($user->entity->isPending()) {
            $allowedRoutes = ['dashboard.index', 'dashboard.entity.settings.edit', 'dashboard.entity.settings.update', 'logout'];
            $currentRoute  = $request->route()?->getName();
            if ($currentRoute && !in_array($currentRoute, $allowedRoutes, true)) {
                Log::info('EnsureEntityOwner:pending-blocked', ['user_id' => $user->id, 'route' => $currentRoute]);
                return redirect()->route('dashboard.index')
                    ->with('warning', 'O teu registo ainda está a aguardar aprovação. Não podes gerir produtos enquanto isso.');
            }
        }

        Log::debug('EnsureEntityOwner:pass', [
            'user_id' => $user->id,
            'entity_id' => $user->entity->id,
        ]);
        return $next($request);
    }
}
