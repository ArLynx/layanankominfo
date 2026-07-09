<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorSetupController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->two_factor_secret) {
            if ($user instanceof \App\Models\Admin) {
                $route = $user->role === 'pimpinan'
                    ? 'pimpinan.dashboard'
                    : 'admin.dashboard';

                return redirect()->route($route);
            }

            return redirect()->route('dashboard');
        }

        return view('auth.2fa-setup');
    }
}
