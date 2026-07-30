<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorForAdmins
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('admin')->check()) {
            return $next($request);
        }

        $user = auth('admin')->user();

        $onSetupPage = $request->is('admin/2fa-setup*');
        $onChallengePage = $request->is('admin/two-factor-challenge*');
        $onLoginPage = $request->is('admin/login');
        $onResetPage = $request->is('admin/two-factor/reset*') || $request->is('two-factor/reset*');

        if ($onSetupPage || $onChallengePage || $onLoginPage || $onResetPage) {
            return $next($request);
        }

        if (!$user->two_factor_secret || !$user->two_factor_confirmed_at) {
            return redirect()->route('admin.2fa.setup');
        }

        return $next($request);
    }
}
