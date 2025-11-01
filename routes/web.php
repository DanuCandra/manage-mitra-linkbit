<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UsersController;

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

Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra-dashboard', [AuthController::class, 'mitra_dashboard'])->name('mitra-dashboard');
});

Route::middleware(['auth', 'role:admin,mitra'])->group(function () {
    // Route untuk admin dan mitra di sini
});

