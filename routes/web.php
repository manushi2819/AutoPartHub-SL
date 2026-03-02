<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PartShopController;
use App\Http\Controllers\Frontend\PartDetailsController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('Frontend.index');
Route::get('/about-us', [HomeController::class, 'about'])->name('Frontend.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('Frontend.contact');

Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/parts-shop', [PartShopController::class, 'index'])->name('Frontend.shop');
Route::get('/parts-details/{id}', [PartDetailsController::class, 'index'])->name('Frontend.parts-details');

Route::get('/cart', [CartController::class, 'index'])->name('Frontend.cart');
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('Frontend.wishlist');
Route::post('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');


Route::get('/checkout', [CartController::class, 'checkout'])->name('Frontend.checkout');

Route::get('/login', [LoginController::class, 'login'])->name('Frontend.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('Frontend.login.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('Frontend.register');
Route::post('/register', [LoginController::class, 'store'])->name('Frontend.register.store');
Route::post('/customer/logout', [LoginController::class, 'logout'])->name('Frontend.logout');


use App\Http\Controllers\Frontend\CustomerProfileController;

Route::prefix('customer')->name('customer.')->middleware('auth:customer')->group(function () {

    Route::get('/dashboard', [CustomerProfileController::class, 'index'])->name('dashboard');
    Route::post('/profile/update', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');

});












// admin login
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\AdminAuth;

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->name('admin.')->middleware([AdminAuth::class])->group(function () {

    Route::get('/', function () {
        return view('AdminDashboard.index');
    })->name('dashboard');

    //categories
    Route::resource('categories', CategoryController::class);

    // Product 
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/images', [ProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::delete('products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');

     // contact messages 
    Route::get('/contact-messages', [ContactController::class, 'index'])->name('contact');
    Route::post('contact-messages/reply/{id}', [ContactController::class, 'reply'])->name('contact.reply');
    Route::delete('/contact-messages/{message}', [ContactController::class, 'destroy'])->name('contact.destroy');

});