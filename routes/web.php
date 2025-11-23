<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;

// === GUEST ===
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// === AUTHENTICATED ===
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // === PETUGAS ===
    Route::middleware('role:petugas')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('penitipan')->name('penitipan.')->group(function () {
            Route::get('/', [PenitipanController::class, 'index'])->name('index');
            Route::get('/create', [PenitipanController::class, 'create'])->name('create');
            Route::post('/store', [PenitipanController::class, 'store'])->name('store');
            Route::get('/{id}', [PenitipanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PenitipanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PenitipanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PenitipanController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/keluar', [PenitipanController::class, 'keluar'])->name('keluar');
            Route::get('/struk/{id}', [PenitipanController::class, 'struk'])->name('struk');
        });

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    });

    // === ADMIN ===
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola Pengguna
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'usersCreate'])->name('create');
            Route::post('/', [AdminController::class, 'usersStore'])->name('store');
            Route::get('/{id}', [AdminController::class, 'usersShow'])->name('show');
            Route::get('/{id}/edit', [AdminController::class, 'usersEdit'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'usersUpdate'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'usersDestroy'])->name('destroy');
        });
;
    });
});
