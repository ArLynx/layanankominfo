<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwoFactorSetupController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth('admin')->user();

        if ($admin?->two_factor_confirmed_at) {
            $route = $admin->role === 'pimpinan'
                ? 'pimpinan.dashboard'
                : 'admin.dashboard';

            return redirect()->route($route);
        }

        return view('auth.2fa-setup');
    }
}