<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CompanyWorkerMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Neoprávnená akcia. Nie ste prihlásený.');
        }

        $role = $user->user_roles->rola;

        if ($role != 'Zástupca firmy alebo organizácie') {
            abort(403, 'Neoprávnená akcia. Nemáte oprávnenia Zástupcu firmy alebo organizácie.');
        }

        return $next($request);
    }
}
