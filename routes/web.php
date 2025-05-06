<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Models\User;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');

Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Define Gates for Authorization
Gate::define('access-reports', fn (User $user) => $user->isSuperAdmin());
Gate::define('manage-users', fn (User $user) => $user->isSuperAdmin());

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Inventory Management (accessible to all authenticated users)
    Route::resource('/items', ItemController::class);
    Route::resource('/stockin', StockInController::class);
    Route::resource('/stockout', StockOutController::class);
    
    // Reports (super admin only)
    Route::prefix('reports')->middleware('can:access-reports')->group(function() {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
        Route::get('/transaction', [ReportController::class, 'transactionReport'])->name('reports.transaction');
        Route::get('/profit', [ReportController::class, 'profitReport'])->name('reports.profit');
        Route::get('/profit/profit/pdf', [ReportController::class, 'profit_pdf'])->name('reports.profit_pdf');
        Route::get('/export/{type}', [ReportController::class, 'exportProfitReport'])->name('export');
        Route::get('/category', [ReportController::class, 'categoryReport'])->name('reports.category');
    });
    
    // User Management (super admin only)
    Route::resource('users', UserController::class)->middleware('can:manage-users');
});