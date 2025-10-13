<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard contoh
// Route::middleware('auth')->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return "Halaman Admin";
//     })->name('admin.dashboard')->middleware('role:admin');

//     Route::get('/petugas/dashboard', function () {
//         return "Halaman Petugas";
//     })->name('petugas.dashboard')->middleware('role:petugas');
// });

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/penitipan', [PenitipanController::class, 'index'])->name('penitipan.index');
Route::get('/penitipan/{id}', [PenitipanController::class, 'show'])->name('penitipan.show');
Route::get('/penitipan/create', [PenitipanController::class, 'create'])->name('penitipan.create');
Route::get('/penitipan/{id}/edit', [PenitipanController::class, 'edit'])->name('penitipan.edit');
Route::get('/penitipan/struk/{id}', [PenitipanController::class, 'struk'])->name('penitipan.struk');
Route::put('/penitipan/{id}', [PenitipanController::class, 'update'])->name('penitipan.update');
Route::post('/penitipan/store', [PenitipanController::class, 'store'])->name('penitipan.store');
Route::post('/penitipan/keluar/{id}', [PenitipanController::class, 'keluar'])->name('penitipan.keluar');
Route::delete('/penitipan/{id}', [PenitipanController::class, 'destroy'])->name('penitipan.destroy');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
