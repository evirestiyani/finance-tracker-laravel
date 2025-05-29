<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [TransactionController::class, 'index'])->name('dashboard');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transactions.store');

    // Export laporan ke PDF
    Route::get('/report/export-pdf', [ReportController::class, 'exportPdf'])->name('report.exportPdf');
});
