<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/',[DashboardController::class,'index'])->name('dashboard');

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::resource('login',LoginController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('/admin')->name('admin.')->middleware(['auth','role:admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('options', OptionController::class);
    Route::resource('stock', StockController::class);
    Route::resource('profile', AdminProfileController::class);
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
