<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\MainPosterController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Customer\CartContactInformationController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::resource('login',LoginController::class)->only(['store']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/',[DashboardController::class,'index'])->name('dashboard');
Route::post('/main-search',[DashboardController::class, 'mainSearch'])->name('main-search');
// Route::resource('wishlist', WishListController::class)->only(['index', 'update']);

//product
Route::get('/products/{id}', [CustomerProductController::class, 'productDetail'])->name('customer.products.show');
Route::get('/products', [CustomerProductController::class,'productsPage'])->name('customer.product.page');

//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::delete('cart/delete-all', [CartController::class, 'deleteAll'])->name('cart.deleteAll');
Route::put('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/price-count', [CartController::class, 'getPriceCount'])->name('cart.price-count');
Route::get('/cart/checkout/stock/{id}', [CartController::class, 'checkoutStock'])->name('cart.checkout.stock');


//admin
Route::prefix('/admin')->name('admin.')->middleware(['auth','role:admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('profile', AdminProfileController::class);
    Route::resource('main-categories', MainCategoryController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);

    // Main Store Poster / Banner UI Module
    Route::get('/banners', [MainPosterController::class, 'index'])->name('banners.index');
    Route::post('/banners', [MainPosterController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{id}', [MainPosterController::class, 'destroy'])->name('banners.delete');
    Route::get('/banners/{id}/edit',[MainPosterController::class,'edit'])->name('banners.edit');
    Route::put('/banners/{id}/update',[MainPosterController::class,'update'])->name('banners.update');
    
    //option
    Route::resource('options', OptionController::class);
    Route::delete('product/option/delete', [ProductController::class,'deleteProductOption'])->name('product.option.delete');

    //setting
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    
    //product
    Route::post('product/option/status',[ProductController::class,'optionStatusChange'])->name('option.status.change');

    Route::prefix('notifications')->name('notifications.')->controller(AdminDashboardController::class)->group(function () {

        Route::get('/', 'notification')->name('index');

        Route::post('/{id}/read', 'markAsRead')->name('read');

        Route::post('/read-all', 'markAllAsRead')->name('readAll');

        Route::delete('/{id}', 'destroy')->name('destroy');

    });

   });


//customers
Route::middleware('auth')->group(function() {

    //customer address
    Route::resource('checkout/contact', CartContactInformationController::class);
    Route::get('/checkout/check-contact', [CartContactInformationController::class, 'checkContact']);

    //payment
    Route::get('/checkout/payment', [PaymentController::class, 'index'])->name('checkout.payment');
    Route::post('/checkout/payment', [PaymentController::class,'store'])->name('checkout.payment.store');
    Route::get('/checkout/success', [PaymentController::class, 'paymentSuccess'])->name('checkout.payment.success');
    Route::get('/check/stock',[PaymentController::class, 'checkStock'])->name('checkStock');

    //all orders
    Route::get('/my-orders',[OrderController::class, 'myOrders'])->name('orders');
    Route::get('/order/{id}/cancel', [OrderController::class, 'orderCancel'])->name('order.cancel');
    Route::get('/order/details', [OrderController::class, 'orderDetail'])->name('order.details');

    //coupons apply
    Route::get('/get-coupon',[CouponController::class, 'getCoupon'])->name('getCoupon');
    Route::post('/remove-coupon',[CouponController::class, 'removeCoupon'])->name('removeCoupon');
});


Route::get('/register', function () {
    return view('auth.register');
})->name('register');
