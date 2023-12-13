<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Neoprávnená akcia. Nie ste prihlásený.');
        }

        $role = $user->user_roles->rola;

        if ($role != 'Študent') {
            abort(403, 'Neoprávnená akcia. Nemáte oprávnenia študenta.');
        }

        return $next($request);
    }
}
