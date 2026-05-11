<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\PenyusutanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('auth/google/redirect', [App\Http\Controllers\Auth\GoogleController::class, 'google_redirect'])
    ->middleware('guest')
    ->name('google.redirect');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'google_callback'])
    ->middleware('guest')
    ->name('google.callback');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->group(function () {

        // --- PROFILE ---
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::delete('/jenis-barang/bulk-delete', [App\Http\Controllers\JenisBarangController::class, 'bulkDelete'])->name('jenis-barang.bulk-delete');
        Route::resource('/jenis-barang', App\Http\Controllers\JenisBarangController::class);
        Route::delete('/status-barang/bulk-delete', [App\Http\Controllers\StatusBarangController::class, 'bulkDelete'])->name('status-barang.bulk-delete');
        Route::resource('/status-barang', App\Http\Controllers\StatusBarangController::class);

        Route::delete('/kondisi-barang/bulk-delete', [App\Http\Controllers\KondisiBarangController::class, 'bulkDelete'])->name('kondisi-barang.bulk-delete');
        Route::resource('/kondisi-barang', App\Http\Controllers\KondisiBarangController::class);

        Route::delete('/users/bulk-delete', [App\Http\Controllers\UserController::class, 'bulkDelete'])->name('users.bulk-delete');
        Route::resource('/users', App\Http\Controllers\UserController::class);

        Route::delete('/lokasi-penyimpanan/bulk-delete', [App\Http\Controllers\LokasiPenyimpananController::class, 'bulkDelete'])->name('lokasi-penyimpanan.bulk-delete');
        Route::resource('/lokasi-penyimpanan', App\Http\Controllers\LokasiPenyimpananController::class);

        Route::delete('/nama-ruang/bulk-delete', [App\Http\Controllers\NamaRuangController::class, 'bulkDelete'])->name('nama-ruang.bulk-delete');
        Route::resource('/nama-ruang', App\Http\Controllers\NamaRuangController::class);

        Route::delete('/barang/bulk-delete', [App\Http\Controllers\BarangController::class, 'bulkDelete'])->name('barang.bulk-delete');
        Route::resource('/barang', App\Http\Controllers\BarangController::class);
        Route::get('/barang-export', [App\Http\Controllers\BarangController::class, 'export'])->name('barang.export');
        Route::get('/barang/{barang}/cetak-label', [App\Http\Controllers\BarangController::class, 'cetakLabel'])->name('barang.cetak-label');

        Route::get('/stok-opnames/barang-by-ruang', [App\Http\Controllers\StokOpnameController::class, 'getBarangByRuang'])->name('stok-opnames.barang-by-ruang');
        Route::resource('/stok-opnames', App\Http\Controllers\StokOpnameController::class)->only(['index', 'create', 'store', 'show']);

        Route::resource('/penyesuaians', App\Http\Controllers\PenyesuaianController::class)->except(['index']);

        Route::get('/penyusutans', [PenyusutanController::class, 'index'])->name('penyusutans.index');
        Route::post('/penyusutans/generate', [PenyusutanController::class, 'generate'])->name('penyusutans.generate');

    });
});


require __DIR__ . '/auth.php';
