<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

// No access
Route::get('/no-access', function(){
    return view('noaccess');
})->name('no.access');

// Protected by session middleware (auth.session)
Route::middleware(['auth.session'])->group(function() {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    // Barang CRUD + my items
    Route::get('/barang', [BarangController::class,'index'])->name('barang.index');
    Route::get('/barang/my', [BarangController::class,'myItems'])->name('barang.my');
    Route::get('/barang/create', [BarangController::class,'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class,'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class,'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class,'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class,'destroy'])->name('barang.destroy');

    // Users list: Superadmin + Admin
    Route::middleware(['role:superadmin,admin'])->group(function(){
        Route::get('/users', [UserController::class,'index'])->name('users.index');
    });

    // Superadmin-only create & delete user
    Route::middleware(['role:superadmin'])->group(function(){
        Route::get('/users/create', [UserController::class,'create'])->name('users.create');
        Route::post('/users', [UserController::class,'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class,'destroy'])->name('users.destroy');
    });

    // Admin & Superadmin: edit permissions
    Route::middleware(['role:superadmin,admin'])->group(function(){
        Route::get('/users/{id}/permissions', [PermissionController::class,'edit'])->name('users.permissions.edit');
        Route::post('/users/{id}/permissions', [PermissionController::class,'update'])->name('users.permissions.update');
    });
});
