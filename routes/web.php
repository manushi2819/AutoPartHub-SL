<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PartShopController;
use App\Http\Controllers\Frontend\PartDetailsController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ReviewController;

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

Route::get('/checkout', [CheckoutController::class, 'index'])->name('Frontend.checkout');
Route::post('/checkout/process', [CheckoutController::class, 'placeOrder'])->name('Frontend.checkout.process');
Route::get('/checkout/success/{order_id}', [CheckoutController::class,'success'])->name('Frontend.checkout.success');

Route::get('/login', [LoginController::class, 'login'])->name('Frontend.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('Frontend.login.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('Frontend.register');
Route::post('/register', [LoginController::class, 'store'])->name('Frontend.register.store');
Route::post('/customer/logout', [LoginController::class, 'logout'])->name('Frontend.logout');

Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review.store');



use App\Http\Controllers\Frontend\CustomerProfileController;

Route::prefix('customer')->name('customer.')->middleware('auth:customer')->group(function () {

    Route::get('/dashboard', [CustomerProfileController::class, 'index'])->name('dashboard');
    Route::post('/profile/update', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/order/track/{order}', [OrderController::class, 'track'])->name('order.track');

});












// admin login
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
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

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/track/{order}', [OrderController::class, 'track'])->name('orders.track');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});