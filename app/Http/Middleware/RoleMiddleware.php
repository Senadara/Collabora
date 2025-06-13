<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/'); // belum login
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request); // role cocok
        }

        return abort(403, 'Unauthorized');
    }
}
