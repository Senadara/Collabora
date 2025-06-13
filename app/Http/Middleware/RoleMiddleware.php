<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user()->account ?? Auth::user(); // tergantung relasi

        $roleList = explode('|', $roles);

        if (!in_array($user->role, $roleList)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

