<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\TwoFactorOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactorResetController extends Controller
{
    public function showRequestForm()
    {
        return view('admin.auth.2fa-reset');
    }

    public function sendOtpByEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin->two_factor_secret || !$admin->two_factor_confirmed_at) {
            return back()->withErrors(['email' => 'Two-Factor Authentication belum diaktifkan pada akun ini.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('2fa_reset_admin_' . $admin->email, $otp, now()->addMinutes(10));

        $admin->notify(new TwoFactorOtp($otp));

        return redirect()->route('admin.2fa.reset.show', ['email' => $admin->email]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['password' => 'required']);

        $admin = auth('admin')->user();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('2fa_reset_admin_' . $admin->email, $otp, now()->addMinutes(10));

        $admin->notify(new TwoFactorOtp($otp));

        return redirect()->route('admin.2fa.reset.show', ['email' => $admin->email]);
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');

        if (!$email || !Cache::has('2fa_reset_admin_' . $email)) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Sesi tidak valid. Silakan ulangi.']);
        }

        return view('admin.auth.2fa-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email|exists:admins,email',
        ]);

        $email = $request->email;
        $cached = Cache::get('2fa_reset_admin_' . $email);

        if (!$cached || $cached !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        Cache::forget('2fa_reset_admin_' . $email);

        $admin = Admin::where('email', $email)->first();

        if ($admin) {
            app(DisableTwoFactorAuthentication::class)($admin);
        }

        return redirect()->route('admin.login')->with('status', 'Two-Factor Authentication berhasil di-reset. Silakan login dan aktifkan kembali 2FA Anda.');
    }
}