<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            $guard = $request->is('admin/*') || $request->is('pimpinan/*')
                ? 'admin'
                : 'web';

            return redirect()->route($guard === 'admin' ? 'admin.login' : 'login');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}