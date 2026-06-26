<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorSetupController extends Controller
{
    public function index()
    {
        if (auth()->user()->two_factor_secret) {
            return redirect()->route('dashboard');
        }

        return view('auth.2fa-setup');
    }
}
