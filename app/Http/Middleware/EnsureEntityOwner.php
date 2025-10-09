<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if (!$user->entity) {
            Log::warning('EnsureEntityOwner:missing-entity', ['user_id' => $user->id]);
            throw new AccessDeniedHttpException('Crie uma entidade para continuar.');
        }
        Log::debug('EnsureEntityOwner:pass', [
            'user_id' => $user->id,
            'entity_id' => $user->entity->id,
        ]);
        return $next($request);
    }
}
