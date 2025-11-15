<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DokumenController;

// PER LOGINAN GAYS WKWK
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'redirectToDashboard'])->name('redirectToDashboard');
    Route::get('/admin-dashboard', [AuthController::class, 'admin_dashboard'])->name('admin-dashboard');

    // ini user
    Route::get('/manage-users', [UsersController::class, 'index']);
    Route::get('/manage-users/create', [UsersController::class, 'create']);
    Route::post('/manage-users/store', [UsersController::class, 'store']);
    Route::get('/user/delete/{id}', [UsersController::class, 'destroy'])->name('delete-user');
    Route::get('/manage-users/edit/{id}', [UsersController::class, 'edit'])->name('edit-user');
    Route::post('/manage-users/update/{id}', [UsersController::class, 'update'])->name('update-user');
});

// khusus mitra
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra-dashboard', [AuthController::class, 'mitra_dashboard'])->name('mitra-dashboard');

    // profile mitra
    Route::get('/profile/add-profile', [MitraController::class, 'add_profile'])->name('add_profile');
    Route::post('/profile/store-profile', [MitraController::class, 'store_profile'])->name('store_profile');
    Route::get('/profile/edit-profile/{id}', [MitraController::class, 'edit_profile'])->name('edit_profile');
    Route::post('/profile/update-profile/{id}', [MitraController::class, 'update_profile'])->name('update_profile');
    Route::get('/profile/view-profile/{id}', [MitraController::class, 'view_profile'])->name('view_profile');

    // dokumen mitra
    Route::get('/dokumen/manage-dokumen', [DokumenController::class, 'manage_dokumen'])->name('dokumen.manage');
    Route::get('/dokumen/create/', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen/store/', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/view/{id}', [DokumenController::class, 'view'])->name('dokumen.view');
    Route::delete('/dokumen/delete/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::get('/dokumen/edit/{id}', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::post('/dokumen/update/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::get('/dokumen/download-all/{id}', [DokumenController::class, 'downloadAll'])->name('dokumen.downloadAll');
});

Route::middleware(['auth', 'role:admin,mitra'])->group(function () {
    // Route untuk admin dan mitra di sini
});
