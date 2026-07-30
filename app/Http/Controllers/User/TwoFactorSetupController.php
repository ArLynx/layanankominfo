<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwoFactorSetupController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user?->two_factor_confirmed_at) {
            return redirect()->route('dashboard-user');
        }

        return view('auth.2fa-setup');
    }
}