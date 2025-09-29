<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $role = $request->session()->get('role', null);
        if (!$role) return redirect()->route('login');

        if (!in_array($role, $roles)) {
            return redirect()->route('no.access');
        }

        return $next($request);
    }
}
