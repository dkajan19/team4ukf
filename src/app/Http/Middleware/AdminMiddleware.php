<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Neoprávnená akcia. Nie ste prihlásený.');
        }

        $role = $user->user_roles->rola;

        if ($role != 'admin') {
            abort(403, 'Neoprávnená akcia. Nemáte oprávnenia administrátora.');
        }

        return $next($request);
    }
}
