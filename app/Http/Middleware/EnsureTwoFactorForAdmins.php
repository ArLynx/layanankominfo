<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorForAdmins
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check()) {
            $user = auth('admin')->user();

            $onSetupPage = $request->is('admin/2fa-setup') || $request->is('admin/2fa-setup*');
            $onChallengePage = $request->is('admin/two-factor-challenge') || $request->is('admin/two-factor-challenge*');
            $onLoginPage = $request->is('admin/login');

            if (!$user->two_factor_secret && !$onSetupPage && !$onChallengePage && !$onLoginPage) {
                return redirect()->route('admin.2fa.setup');
            }

            if ($user->two_factor_secret && !$user->two_factor_confirmed_at && !$onSetupPage && !$onChallengePage && !$onLoginPage) {
                return redirect()->route('admin.2fa.setup');
            }
        }

        return $next($request);
    }
}
