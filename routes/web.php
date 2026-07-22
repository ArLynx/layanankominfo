<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PimpinanNotificationController;

use App\Http\Controllers\Admin\SubdomainAdminController;
use App\Http\Controllers\Admin\EmailSatkerAdminController;
use App\Http\Controllers\Admin\EmailPribadiAdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\TwoFactorSetupController;

//User
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\User\JenisLayananController;
use App\Http\Controllers\User\SubdomainController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\EmailPribadiController;
use App\Http\Controllers\User\EmailSatkerController;
use App\Http\Controllers\User\NotificationUserController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Auth Routes
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])
            ->middleware('guest:admin')
            ->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])
            ->middleware('guest:admin')
            ->name('login');
        Route::get('/two-factor-challenge', [App\Http\Controllers\Admin\AuthController::class, 'showChallengeForm'])
            ->middleware('guest:admin')
            ->name('2fa.challenge');
        Route::post('/two-factor-challenge', [App\Http\Controllers\Admin\AuthController::class, 'challenge'])
            ->middleware('guest:admin')
            ->name('2fa.challenge');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])
            ->middleware('auth:admin')
            ->name('logout');
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
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/success/{id}', [RequestController::class, 'success'])->name('requests.success')->whereNumber('id');
    Route::get('/requests/{id}/edit', [RequestController::class, 'edit'])->name('requests.edit')->whereNumber('id');
    Route::patch('/requests/{id}', [RequestController::class, 'update'])->name('requests.update')->whereNumber('id');

});

// Admin 2FA Setup — tanpa role filter biar admin & pimpinan bisa akses
Route::middleware(['auth:admin', '2fa.admin', 'nocache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/2fa-setup', [App\Http\Controllers\TwoFactorSetupController::class, 'index'])->name('2fa.setup');
    });

// Shared Admin & Superadmin Routes
Route::middleware(['auth:admin', '2fa.admin', 'nocache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

// Admin-only Routes
Route::middleware(['auth:admin', 'role:admin', '2fa.admin', 'nocache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
        Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');

        //notif
        Route::get('/notifications/read/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

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

// Superadmin-only Routes
Route::middleware(['auth:admin', 'role:superadmin', '2fa.admin', 'nocache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // User Management (users table)
        Route::get('/users', [SuperAdminUserController::class, 'index'])->name('users');
        Route::get('/users/create', [SuperAdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [SuperAdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [SuperAdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [SuperAdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [SuperAdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/reset-password', [SuperAdminUserController::class, 'resetPassword'])->name('users.reset-password');

        // Admin Management (admins table)
        Route::get('/admins', [AdminController::class, 'index'])->name('admins');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
        Route::post('/admins/{admin}/reset-password', [AdminController::class, 'resetPassword'])->name('admins.reset-password');

        // Log Aktivitas
        // Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    
    });

// Pimpinan Routes
Route::middleware(['auth:admin', 'role:pimpinan', '2fa.admin', 'nocache'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'index'])->name('dashboard');

        // Notifikasi
        Route::get('/notifications', [PimpinanNotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{notification}/read', [PimpinanNotificationController::class, 'read'])->name('notifications.read');

        // Subdomain
        Route::get('/pengajuan/subdomain', [PimpinanController::class, 'subdomainList'])->name('subdomain.list');
        Route::get('/pengajuan/subdomain/{subdomain}', [PimpinanController::class, 'showDetail'])->name('subdomain.show');
        Route::get('/pengajuan/subdomain/{subdomain}/formulir', [PimpinanController::class, 'viewFormulir'])->name('subdomain.formulir');

        // Email Satker
        Route::get('/pengajuan/email-satker', [PimpinanController::class, 'emailSatkerList'])->name('email-satker.list');
        Route::get('/pengajuan/email-satker/{emailSatker}', [PimpinanController::class, 'emailSatkerDetail'])->name('email-satker.detail');
        Route::get('/pengajuan/email-satker/{emailSatker}/formulir', [PimpinanController::class, 'emailSatkerFormulir'])->name('email-satker.formulir');

        // Subdomain Approval
        Route::get('/persetujuan-pimpinan', [PimpinanController::class, 'approvalList'])->name('approval-list');
        Route::get('/persetujuan-pimpinan/{subdomain}', [PimpinanController::class, 'approvalShow'])->name('approval-show');
        Route::post('/persetujuan-pimpinan/{subdomain}/approve', [PimpinanController::class, 'approve'])->name('approve-subdomain');
        Route::post('/persetujuan-pimpinan/{subdomain}/reject', [PimpinanController::class, 'reject'])->name('reject-subdomain');

        // Email Satker Approval
        Route::get('/persetujuan-email-satker', [PimpinanController::class, 'emailSatkerApprovalList'])->name('email-satker.approval-list');
        Route::get('/persetujuan-email-satker/{emailSatker}', [PimpinanController::class, 'emailSatkerApprovalShow'])->name('email-satker.approval-show');
        Route::post('/persetujuan-email-satker/{emailSatker}/approve', [PimpinanController::class, 'emailSatkerApprove'])->name('email-satker.approve');
        Route::post('/persetujuan-email-satker/{emailSatker}/reject', [PimpinanController::class, 'emailSatkerReject'])->name('email-satker.reject');

        // Email Pribadi
        Route::get('/pengajuan/email-pribadi', [PimpinanController::class, 'emailPribadiList'])->name('email-pribadi.list');
        Route::get('/pengajuan/email-pribadi/{emailPribadi}', [PimpinanController::class, 'emailPribadiDetail'])->name('email-pribadi.detail');
        Route::get('/pengajuan/email-pribadi/{emailPribadi}/formulir', [PimpinanController::class, 'emailPribadiFormulir'])->name('email-pribadi.formulir');

        // Email Pribadi Approval
        Route::get('/persetujuan-email-pribadi', [PimpinanController::class, 'emailPribadiApprovalList'])->name('email-pribadi.approval-list');
        Route::get('/persetujuan-email-pribadi/{emailPribadi}', [PimpinanController::class, 'emailPribadiApprovalShow'])->name('email-pribadi.approval-show');
        Route::post('/persetujuan-email-pribadi/{emailPribadi}/approve', [PimpinanController::class, 'emailPribadiApprove'])->name('email-pribadi.approve');
        Route::post('/persetujuan-email-pribadi/{emailPribadi}/reject', [PimpinanController::class, 'emailPribadiReject'])->name('email-pribadi.reject');
    });

//User Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', '2fa.ensure'])->group(function () {
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->name('dashboard-user');

    Route::get('/jenis-layanan', [JenisLayananController::class, 'index'])
        ->name('jenis-layanan')
        ->middleware('profile.complete');

    // Profile
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

    // Notifikasi
    Route::get('/notifications', [NotificationUserController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/read', [NotificationUserController::class, 'read'])->name('notifications.read');

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
