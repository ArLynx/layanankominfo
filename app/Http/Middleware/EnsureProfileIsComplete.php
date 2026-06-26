<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isProfileComplete()) {
            return redirect()->route('profile.show')->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu sebelum melanjutkan.');
        }

        return $next($request);
    }
}
