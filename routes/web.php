<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PimpinanController;

use App\Http\Controllers\Admin\SubdomainAdminController;
use App\Http\Controllers\Admin\EmailSatkerAdminController;
use App\Http\Controllers\Admin\EmailPribadiAdminController;

use App\Http\Controllers\TwoFactorSetupController;

//User
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\User\JenisLayananController;
use App\Http\Controllers\User\SubdomainController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\EmailPribadiController;
use App\Http\Controllers\User\EmailSatkerController;

Route::get('/', function () {
    return view('welcome');
});

// 2FA Reset (unauthenticated - from login page)
Route::get('/two-factor/reset/request', [App\Http\Controllers\TwoFactorResetController::class, 'showRequestForm'])->name('2fa.reset.request');
Route::post('/two-factor/reset/request', [App\Http\Controllers\TwoFactorResetController::class, 'sendOtpByEmail'])->name('2fa.reset.send-email');
Route::get('/two-factor/reset', [App\Http\Controllers\TwoFactorResetController::class, 'showOtpForm'])->name('2fa.reset.show');
Route::post('/two-factor/reset/verify', [App\Http\Controllers\TwoFactorResetController::class, 'verifyOtp'])->name('2fa.reset.verify');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/2fa-setup', [TwoFactorSetupController::class, 'index'])->name('2fa.setup');

    // 2FA Reset via OTP (authenticated - from profile page)
    Route::post('/two-factor/reset/send', [App\Http\Controllers\TwoFactorResetController::class, 'sendOtp'])->name('2fa.reset.send');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', '2fa.ensure'])->group(function () {
    // Permohonan User
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/service', [RequestController::class, 'create'])->name('requests.service');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/success/{id}', [RequestController::class, 'success'])->name('requests.success');
    Route::get('/requests/{id}/edit', [RequestController::class, 'edit'])->name('requests.edit');
    Route::patch('/requests/{id}', [RequestController::class, 'update'])->name('requests.update');

    // Di routes/web.php
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->role === 'pimpinan') {
            return redirect()->route('pimpinan.dashboard');
        }
        $applications = App\Models\RequestApplication::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('dashboard', compact('applications'));
    })
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
});

// Admin Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin', '2fa.ensure'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users');

        // Proses Permohonan
        Route::get('/process', [ProcessController::class, 'index'])->name('process');
        Route::get('/process/history', [ProcessController::class, 'history'])->name('process.history');
        Route::patch('/process/{id}', [ProcessController::class, 'updateStatus'])->name('process.update');
        Route::get('/subdomain-requests', [ProcessController::class, 'subdomainRequests'])->name('subdomain_requests');
        Route::get('/email-requests', [ProcessController::class, 'emailRequests'])->name('email_requests');

        // Pengajuan Subdomain
        Route::get('/pengajuan/subdomain', [SubdomainAdminController::class, 'index'])->name('subdomain');
        Route::get('/pengajuan/subdomain/{subdomain}', [SubdomainAdminController::class, 'show'])->name('subdomain.show');
        Route::delete('/admin/subdomain/{subdomain}', [SubdomainAdminController::class, 'destroy'])->name('subdomain.destroy');
        Route::patch('/subdomain/{subdomain}/update-status', [SubdomainAdminController::class, 'updateStatus'])->name('subdomain.update-status');
        Route::patch('/subdomain/{subdomain}/send-to-leader', [SubdomainAdminController::class, 'sendToLeader'])->name('subdomain.send-to-leader');
        Route::get('/subdomain/{subdomain}/sk-pegawai', [SubdomainAdminController::class, 'viewKarpeg'])->name('subdomain.karpeg');
        Route::get('/subdomain/{subdomain}/formulir', [SubdomainAdminController::class, 'viewFormulir'])->name('subdomain.formulir');
        Route::delete('/subdomain/{subdomain}/delete-formulir', [SubdomainAdminController::class, 'deleteFormulir'])->name('subdomain.delete-formulir');
        Route::get('/subdomain/{subdomain}/cetak-sk', [SubdomainAdminController::class, 'cetakSk'])->name('subdomain.cetak-sk');
        Route::post('/subdomain/{subdomain}/upload-sk', [SubdomainAdminController::class, 'uploadSkPenunjukan'])->name('subdomain.upload-sk');
        Route::get('/subdomain/{subdomain}/download-sk', [SubdomainAdminController::class, 'downloadSkPenunjukan'])->name('subdomain.download-sk');
        Route::get('/admin/subdomain/{subdomain}/surat-lama', [SubdomainAdminController::class, 'suratLama'])->name('subdomain.surat-lama');

        //sementara
        Route::get('/persetujuan-pimpinan', [SubdomainAdminController::class, 'approvalList'])->name('approval-list');

        Route::get('/persetujuan-pimpinan/{subdomain}', [SubdomainAdminController::class, 'approvalShow'])->name('approval-show');

        Route::post('/persetujuan-pimpinan/{subdomain}/approve', [SubdomainAdminController::class, 'approve'])->name('approve-subdomain');

        Route::post('/persetujuan-pimpinan/{subdomain}/reject', [SubdomainAdminController::class, 'reject'])->name('reject-subdomain');

        // Pengajuan Email Satker
        Route::get('/pengajuan/email-satker', [EmailSatkerAdminController::class, 'index'])->name('email-satker');
        Route::get('/pengajuan/email-satker/{emailSatker}', [EmailSatkerAdminController::class, 'show'])->name('email-satker.show');
        Route::delete('/email-satker/{emailSatker}', [EmailSatkerAdminController::class, 'destroy'])->name('email-satker.destroy');
        Route::patch('/email-satker/{emailSatker}/update-status', [EmailSatkerAdminController::class, 'updateStatus'])->name('email-satker.update-status');
        Route::get('/email-satker/{emailSatker}/karpeg', [EmailSatkerAdminController::class, 'viewKarpeg'])->name('email-satker.karpeg');
        Route::get('/email-satker/{emailSatker}/formulir', [EmailSatkerAdminController::class, 'viewFormulir'])->name('email-satker.formulir');
        Route::delete('/email-satker/{emailSatker}/delete-formulir', [EmailSatkerAdminController::class, 'deleteFormulir'])->name('email-satker.delete-formulir');
        Route::get('/email-satker/{emailSatker}/cetak-formulir', [EmailSatkerAdminController::class, 'cetakFormulir'])->name('email-satker.cetak-formulir');

        Route::post('/email-satker/{emailSatker}/send-information', [EmailSatkerAdminController::class, 'sendInformation'])->name('email-satker.send-information');
        Route::get('/email-satker/{emailSatker}/preview-information', [EmailSatkerAdminController::class, 'previewInformation'])->name('email-satker.preview-information');
        Route::get('/email-satker/{emailSatker}/information-account', [EmailSatkerAdminController::class, 'previewInformation'])->name('email-satker.information-account');

        // Pengajuan Email Pribadi
        Route::get('/pengajuan/email-pribadi', [EmailPribadiAdminController::class, 'index'])->name('email-pribadi');
        Route::get('/pengajuan/email-pribadi/{emailPribadi}', [EmailPribadiAdminController::class, 'show'])->name('email-pribadi.show');
        Route::delete('/email-pribadi/{emailPribadi}', [EmailPribadiAdminController::class, 'destroy'])->name('email-pribadi.destroy');
        Route::patch('/email-pribadi/{emailPribadi}/update-status', [EmailPribadiAdminController::class, 'updateStatus'])->name('email-pribadi.update-status');
        Route::get('/email-pribadi/{emailPribadi}/karpeg', [EmailPribadiAdminController::class, 'viewKarpeg'])->name('email-pribadi.karpeg');
        Route::get('/email-pribadi/{emailPribadi}/formulir', [EmailPribadiAdminController::class, 'viewFormulir'])->name('email-pribadi.formulir');
        Route::delete('/email-pribadi/{emailPribadi}/delete-formulir', [EmailPribadiAdminController::class, 'deleteFormulir'])->name('email-pribadi.delete-formulir');
        Route::get('/email-pribadi/{emailPribadi}/cetak-formulir', [EmailPribadiAdminController::class, 'cetakFormulir'])->name('email-pribadi.cetak-formulir');
        Route::post('/email-pribadi/{emailPribadi}/send-information', [EmailPribadiAdminController::class, 'sendInformation'])->name('email-pribadi.send-information');

        Route::get('/email-pribadi/{emailPribadi}/preview-information', [EmailPribadiAdminController::class, 'previewInformation'])->name('email-pribadi.preview-information');
        Route::get('/email-pribadi/{emailPribadi}/information-account', [EmailPribadiAdminController::class, 'previewInformation'])->name('email-pribadi.information-account');
    });

// Pimpinan Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:pimpinan', '2fa.ensure'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'index'])->name('dashboard');
    });

//User Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', '2fa.ensure'])->group(function () {
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->name('dashboard-user');

    Route::get('/jenis-layanan', [JenisLayananController::class, 'index'])
        ->name('jenis-layanan')
        ->middleware('profile.complete');

    // Profile
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

    //permohonan subdomain
    Route::get('/subdomain/create', [SubdomainController::class, 'create'])->name('subdomain.create');
    Route::post('/subdomain', [SubdomainController::class, 'store'])->name('subdomain.store');
    Route::get('/subdomain/{subdomain}/success', [SubdomainController::class, 'success'])->name('subdomain.success');
    Route::get('/subdomain/{subdomain}', [SubdomainController::class, 'show'])->name('subdomain.show');
    Route::post('/subdomain/{subdomain}/upload-formulir', [SubdomainController::class, 'uploadFormulir'])->name('subdomain.upload-formulir');
    Route::get('/subdomain/{subdomain}/cetak', [SubdomainController::class, 'cetak'])->name('subdomain.cetak');
    Route::get('/subdomain/{subdomain}/download-formulir', [SubdomainController::class, 'downloadFormulir'])->name('subdomain.download-formulir');
    Route::get('/subdomain/{subdomain}/download-sk-penunjukan', [SubdomainController::class, 'downloadSkPenunjukan'])->name('subdomain.download-sk-penunjukan');
    Route::get('/subdomain/{subdomain}/edit', [SubdomainController::class, 'edit'])->name('subdomain.edit');
    Route::put('/subdomain/{subdomain}', [SubdomainController::class, 'update'])->name('subdomain.update');
    Route::post('/subdomain/{subdomain}/upload-surat-lama', [SubdomainController::class, 'uploadSuratPenunjukanLama'])->name('subdomain.upload-surat-lama');
    Route::get('/subdomain/{subdomain}/download-surat-lama', [SubdomainController::class, 'downloadSuratPenunjukanLama'])->name('subdomain.download-surat-lama');

    //permohonan email satker
    Route::get('/email-satker/create', [EmailSatkerController::class, 'create'])->name('email-satker.create');
    Route::post('/email-satker', [EmailSatkerController::class, 'store'])->name('email-satker.store');
    Route::get('/email-satker/{emailSatker}/success', [EmailSatkerController::class, 'success'])->name('email-satker.success');
    Route::get('/email-satker/{emailSatker}', [EmailSatkerController::class, 'show'])->name('email-satker.show');
    Route::post('/email-satker/{emailSatker}/upload-formulir', [EmailSatkerController::class, 'uploadFormulir'])->name('email-satker.upload-formulir');
    Route::get('/email-satker/{emailSatker}/cetak', [EmailSatkerController::class, 'cetak'])->name('email-satker.cetak');
    Route::get('/email-satker/{emailSatker}/download-formulir', [EmailSatkerController::class, 'downloadFormulir'])->name('email-satker.download-formulir');
    Route::get('/email-satker/{emailSatker}/edit', [EmailSatkerController::class, 'edit'])->name('email-satker.edit');
    Route::put('/email-satker/{emailSatker}', [EmailSatkerController::class, 'update'])->name('email-satker.update');

    //permohonan email pribadi
    Route::get('/email-pribadi/create', [EmailPribadiController::class, 'create'])->name('email-pribadi.create');
    Route::post('/email-pribadi', [EmailPribadiController::class, 'store'])->name('email-pribadi.store');
    Route::get('/email-pribadi/{emailPribadi}/success', [EmailPribadiController::class, 'success'])->name('email-pribadi.success');
    Route::get('/email-pribadi/{emailPribadi}', [EmailPribadiController::class, 'show'])->name('email-pribadi.show');
    Route::post('/email-pribadi/{emailPribadi}/upload-formulir', [EmailPribadiController::class, 'uploadFormulir'])->name('email-pribadi.upload-formulir');
    Route::get('/email-pribadi/{emailPribadi}/cetak', [EmailPribadiController::class, 'cetak'])->name('email-pribadi.cetak');
    Route::get('/email-pribadi/{emailPribadi}/download-formulir', [EmailPribadiController::class, 'downloadFormulir'])->name('email-pribadi.download-formulir');
    Route::get('/email-pribadi/{emailPribadi}/edit', [EmailPribadiController::class, 'edit'])->name('email-pribadi.edit');
    Route::put('/email-pribadi/{emailPribadi}', [EmailPribadiController::class, 'update'])->name('email-pribadi.update');

    //riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat.index')
        ->middleware('profile.complete');
});
