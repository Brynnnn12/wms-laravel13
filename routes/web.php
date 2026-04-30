<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google/redirect', [App\Http\Controllers\Auth\GoogleController::class, 'google_redirect'])
    ->middleware('guest')
    ->name('google.redirect');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'google_callback'])
    ->middleware('guest')
    ->name('google.callback');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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


    });
});

require __DIR__.'/auth.php';
