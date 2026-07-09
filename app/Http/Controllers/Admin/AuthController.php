<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Fortify;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request, TwoFactorAuthenticationProvider $provider)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        if (config('hashing.rehash_on_login', true)) {
            $admin->forceFill([
                'password' => Hash::make($request->password),
            ])->save();
        }

        if ($admin->two_factor_secret && $admin->two_factor_confirmed_at) {
            $request->session()->put([
                'admin.login.id' => $admin->getKey(),
                'admin.login.remember' => $request->boolean('remember'),
            ]);

            return redirect()->route('admin.2fa.challenge');
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));

        $request->session()->regenerate();

        $redirectRoute = $admin->role === 'pimpinan'
            ? route('pimpinan.dashboard')
            : route('admin.dashboard');

        return redirect()->intended($redirectRoute);
    }

    public function showChallengeForm()
    {
        if (!session()->has('admin.login.id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.two-factor-challenge');
    }

    public function challenge(Request $request, TwoFactorAuthenticationProvider $provider)
    {
        $request->validate([
            'code' => 'nullable|string',
            'recovery_code' => 'nullable|string',
        ]);

        $adminId = $request->session()->get('admin.login.id');

        if (!$adminId || !$admin = Admin::find($adminId)) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Sesi telah berakhir. Silakan login kembali.']);
        }

        if ($request->code) {
            $valid = $provider->verify(
                Fortify::currentEncrypter()->decrypt($admin->two_factor_secret),
                $request->code
            );
        } elseif ($request->recovery_code) {
            $valid = !empty($admin->recoveryCodes()) &&
                collect($admin->recoveryCodes())->contains(function ($code) use ($request, $admin) {
                    if (hash_equals($code, $request->recovery_code)) {
                        $admin->replaceRecoveryCode($code);
                        return true;
                    }
                    return false;
                });
        } else {
            $valid = false;
        }

        if (!$valid) {
            return back()->withErrors(['code' => 'Kode yang dimasukkan tidak valid.']);
        }

        $request->session()->forget(['admin.login.id', 'admin.login.remember']);

        Auth::guard('admin')->login($admin, $request->session()->pull('admin.login.remember', false));

        $request->session()->regenerate();

        $redirectRoute = $admin->role === 'pimpinan'
            ? route('pimpinan.dashboard')
            : route('admin.dashboard');

        return redirect()->intended($redirectRoute);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
