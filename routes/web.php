<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PimpinanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
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
        $applications = App\Models\RequestApplication::where('user_id', auth()->id())->latest()->get();
        return view('dashboard', compact('applications'));
    })->middleware(['auth', 'verified'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])
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
    });

// Pimpinan Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:pimpinan'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'index'])->name('dashboard');
    });
