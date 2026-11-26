<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\StudioBookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/inventori/export', [InventoryController::class, 'exportCsv'])->name('inventori.export');
    Route::get('/inventori', [InventoryController::class, 'index'])->name('inventori.index');
    Route::post('/inventori', [InventoryController::class, 'store'])->name('inventori.store');
    Route::put('/inventori/{inventory}', [InventoryController::class, 'update'])->name('inventori.update');
    Route::delete('/inventori/{inventory}', [InventoryController::class, 'destroy'])->name('inventori.destroy');

    // Halaman 1: Logbook Aktif & Modal Pengembalian
    Route::get('/logbook', [LoanController::class, 'index'])->name('logbook.index');
    Route::post('/logbook', [LoanController::class, 'store'])->name('logbook.store');
    Route::post('/logbook/{loan}/return', [LoanController::class, 'returnItem'])->name('logbook.return');

    // Halaman 2: Jadwal Studio
    Route::get('/jadwal', [StudioBookingController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [StudioBookingController::class, 'store'])->name('jadwal.store');
    Route::patch('/jadwal/{booking}/status', [StudioBookingController::class, 'updateStatus'])->name('jadwal.status');

    // Halaman 3: Riwayat & Export CSV
    Route::get('/riwayat', [LoanController::class, 'history'])->name('riwayat.index');
    Route::get('/riwayat/export', [LoanController::class, 'exportCsv'])->name('riwayat.export');
});