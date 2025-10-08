<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureEntityOwner
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !$user->entity) {
            throw new AccessDeniedHttpException('Crie uma entidade para continuar.');
        }
        return $next($request);
    }
}
