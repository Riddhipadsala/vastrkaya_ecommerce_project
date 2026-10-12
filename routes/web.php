<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/',[DashboardController::class,'index'])->name('dashboard');

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::resource('login',LoginController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('/admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
