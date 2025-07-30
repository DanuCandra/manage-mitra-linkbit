<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UsersController;

// PER LOGINAN GAYS WKWK
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/manage-users', [UsersController::class, 'index']);
    Route::get('/manage-users/create', [UsersController::class, 'create']);
    Route::post('/manage-users/store', [UsersController::class, 'store']);
    Route::get('/user/delete/{id}', [UsersController::class, 'destroy'])->name('delete-user');
});



// Route::middleware(['auth', 'role:superadmin'])->group(function () {
//     Route::get('/manage-mitra', [MitraController::class, 'index']);
//     Route::get('/manage-users', [UsersController::class, 'index']);
// });
