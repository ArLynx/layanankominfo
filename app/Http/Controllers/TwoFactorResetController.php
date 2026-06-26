<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TwoFactorOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactorResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.2fa-reset');
    }

    public function sendOtpByEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if (!$user->two_factor_secret) {
            return back()->withErrors(['email' => 'Two-Factor Authentication belum diaktifkan pada akun ini.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('2fa_reset_' . $user->email, $otp, now()->addMinutes(10));

        $user->notify(new TwoFactorOtp($otp));

        return redirect()->route('2fa.reset.show', ['email' => $user->email]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = auth()->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('2fa_reset_' . $user->email, $otp, now()->addMinutes(10));

        $user->notify(new TwoFactorOtp($otp));

        return redirect()->route('2fa.reset.show', ['email' => $user->email]);
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');

        if (!$email || !Cache::has('2fa_reset_' . $email)) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi tidak valid. Silakan ulangi.']);
        }

        return view('auth.2fa-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $cached = Cache::get('2fa_reset_' . $email);

        if (!$cached || $cached !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        Cache::forget('2fa_reset_' . $email);

        $user = User::where('email', $email)->first();

        if ($user) {
            app(DisableTwoFactorAuthentication::class)($user);
        }

        return redirect()->route('login')->with('status', 'Two-Factor Authentication berhasil di-reset. Silakan login dan aktifkan kembali 2FA Anda.');
    }
}
