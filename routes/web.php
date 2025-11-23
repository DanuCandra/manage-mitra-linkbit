<?php

use App\Http\Controllers\AdminMitraController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PelangganController;

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

    // tambah bandwidth
    Route::get('/manage-bandwidth', [AdminMitraController::class, 'manage_bandwidth'])->name('manage-bandwidth');
    Route::post('/manage-bandwidth/add/{id}', [AdminMitraController::class, 'add_bandwidth'])->name('add-bandwidth');
    Route::post('/manage-bandwidth/update/{id}', [AdminMitraController::class, 'update_bandwidth'])->name('update-bandwidth');
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

    // produk mitra
    Route::get('/produk/manage-produk', [ProdukController::class, 'manage_produk'])->name('produk.manage');
    Route::get('/produk/create/', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store/', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/view/{id}', [ProdukController::class, 'view'])->name('produk.view');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');

    // Pelanggan Mitra
    Route::get('/pelanggan/manage', [PelangganController::class, 'manage'])->name('pelanggan.manage');
    Route::get('/pelanggan/create/', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store/', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/view/{id}', [PelangganController::class, 'view'])->name('pelanggan.view');
    Route::delete('/pelanggan/delete/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');

    // Settingan User
    Route::get('/setting/manage', [MitraController::class, 'manage_setting'])->name('setting.manage');
    Route::post('/setting/update/{id}', [MitraController::class, 'update_setting'])->name('setting.update');
});

Route::middleware(['auth', 'role:admin,mitra'])->group(function () {
    // Route untuk admin dan mitra di sini
    // Settingan User
    Route::get('/setting/manage', [MitraController::class, 'manage_setting'])->name('setting.manage');
    Route::post('/setting/update/{id}', [MitraController::class, 'update_setting'])->name('setting.update');
});
