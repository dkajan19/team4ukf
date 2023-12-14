<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HeadWorkerMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Neoprávnená akcia. Nie ste prihlásený.');
        }

        $role = $user->user_roles->rola;

        if ($role != 'Vedúci pracoviska') {
            abort(403, 'Neoprávnená akcia. Nemáte oprávnenia Vedúceho pracoviska.');
        }

        return $next($request);
    }
}
