<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CartContactInformationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::resource('login',LoginController::class)->only(['store']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/',[DashboardController::class,'index'])->name('dashboard');
// Route::resource('wishlist', WishListController::class)->only(['index', 'update']);
Route::get('/products/{id}', [ProductController::class, 'productDetail'])->name('customer.products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::delete('cart/delete-all', [CartController::class, 'deleteAll'])->name('cart.deleteAll');
Route::put('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/price-count', [CartController::class, 'getPriceCount'])->name('cart.price-count');
Route::get('/cart/checkout/stock/{id}', [CartController::class, 'checkoutStock'])->name('cart.checkout.stock');

Route::prefix('/admin')->name('admin.')->middleware(['auth','role:admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('options', OptionController::class);
    Route::resource('stock', StockController::class);
    Route::resource('profile', AdminProfileController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('product/option/status',[ProductController::class,'optionStatusChange'])->name('option.status.change');
    Route::resource('coupons', CouponController::class);
   
   });

Route::middleware('auth')->group(function() {
    Route::post('option-value/price/change',[ProductController::class,'optionValuePriceChange'])->name('option-value.price.change');
    Route::resource('checkout/contact', CartContactInformationController::class);
    Route::get('/chcekout/payment', [PaymentController::class, 'index'])->name('checkout.payment');
    Route::post('/checkout/payment', [PaymentController::class,'store'])->name('checkout.payment.store');
    Route::get('/checkout/success', [PaymentController::class, 'paymentSuccess'])->name('checkout.payment.success');
    Route::get('/checkout/order-details', [PaymentController::class, 'orderDetail'])->name('checkout.order.details');
    Route::get('/my-orders',[PaymentController::class, 'myOrders'])->name('orders');
    Route::get('/order/{id}/cancel', [PaymentController::class, 'orderCancel'])->name('order.cancel');
    Route::get('/order/details', [PaymentController::class, 'orderDetail'])->name('order.details');
});


Route::get('/register', function () {
    return view('auth.register');
})->name('register');
