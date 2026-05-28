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
use App\Http\Controllers\Frontend\BuynowCheckoutController;
use App\Http\Controllers\Frontend\ForgotPasswordController;
use App\Http\Controllers\Frontend\VehicleController;
use App\Http\Controllers\Frontend\FrontendAuctionController;

Route::get('/', [HomeController::class, 'index'])->name('Frontend.index');
Route::get('/about-us', [HomeController::class, 'about'])->name('Frontend.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('Frontend.contact');

Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/parts-shop', [PartShopController::class, 'index'])->name('Frontend.shop');
Route::get('/search-suggestions', [PartShopController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('/parts-details/{id}', [PartDetailsController::class, 'index'])->name('Frontend.parts-details');


Route::get('/vehicles', [VehicleController::class, 'index'])->name('Frontend.vehicles');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('Frontend.vehicle.details');
Route::post('/vehicle-inquiry', [VehicleController::class, 'sendInquiry'])->name('vehicle.inquiry');

Route::get('/cart', [CartController::class, 'index'])->name('Frontend.cart');
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('Frontend.wishlist');
Route::post('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('Frontend.checkout');
Route::post('/checkout/process', [CheckoutController::class, 'placeOrder'])->name('Frontend.checkout.process');


// Show Buy Now checkout page
Route::get('/buy-now/{product}/{quantity?}', [BuynowCheckoutController::class, 'buyNow'])->name('Frontend.buyNow');
Route::post('/buy-now/checkout/process', [BuynowCheckoutController::class, 'placeOrder'])->name('Frontend.buyNowcheckout.process');

Route::get('/checkout/cod-success/{order_id}', [CheckoutController::class, 'codSuccess'])
    ->name('Frontend.checkout.cod_success');

Route::post('/checkout/success/{order_id}', [CheckoutController::class, 'success'])
    ->name('Frontend.checkout.success.post')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class, 'web']);


Route::get('/auctions', [FrontendAuctionController::class, 'index'])->name('Frontend.auctions');
Route::get('/auctions/{id}', [FrontendAuctionController::class, 'detail'])->name('Frontend.auction.details');
Route::post('/auction/bid', [FrontendAuctionController::class, 'placeBid'])->name('auction.bid');
Route::get('/auction/{id}/bid-count', [FrontendAuctionController::class, 'bidCount'])->name('auction.bidCount');

//customer routes
Route::get('/login', [LoginController::class, 'login'])->name('Frontend.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('Frontend.login.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('Frontend.register');
Route::post('/register', [LoginController::class, 'store'])->name('Frontend.register.store');
Route::post('/customer/logout', [LoginController::class, 'logout'])->name('Frontend.logout');

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password');
Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('send.otp');

Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('verify.otp.post');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset.password');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password.post');



use App\Http\Controllers\Frontend\CustomerProfileController;
use App\Http\Controllers\Frontend\CustomerAuctionBidController;

Route::prefix('customer')->name('customer.')->middleware('auth:customer')->group(function () {

    Route::get('/dashboard', [CustomerProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [CustomerProfileController::class, 'update'])->name('profile.update');

    Route::get('/password', [CustomerProfileController::class, 'password'])->name('password');
    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/orders', [CustomerProfileController::class, 'orders'])->name('orders');
    Route::get('/order/track/{order}', [CustomerProfileController::class, 'track'])->name('order.track');
    Route::put('/order/{order}/update-delivered', [CustomerProfileController::class, 'updateDeliveredStatus'])->name('order.updateStatus');

    Route::get('/auction-bids', [CustomerAuctionBidController::class, 'index'])->name('auctionbids');
    Route::get('/auction-bids/{id}', [CustomerAuctionBidController::class, 'show'])->name('auction.bids.show');
    
}); 












// admin login
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\AuctionController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\AuctionBidController;
use App\Http\Controllers\Admin\AuctionWinnerController;
use App\Http\Controllers\Admin\AdminUserController;

use App\Http\Middleware\AdminAuth;

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->name('admin.')->middleware([AdminAuth::class])->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

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
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers/{customer}/update-status', [CustomerController::class, 'updateStatus'])->name('customers.updateStatus');


    // vehicles
    Route::resource('vehicles', AdminVehicleController::class);
    Route::post('vehicles/{vehicle}/images', [AdminVehicleController::class, 'uploadImages'])->name('vehicles.images.upload');
    Route::delete('vehicles/images/{image}', [AdminVehicleController::class, 'deleteImage'])->name('vehicles.images.delete');
    

    // auctions
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');

    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions/store', [AuctionController::class, 'store'])->name('auctions.store');
    Route::delete('/auctions/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');

    Route::get('/auctions/{id}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{id}/update', [AuctionController::class, 'update'])->name('auctions.update');
    Route::get('/auction-bids', [AuctionBidController::class, 'index'])->name('auction.bids');
    Route::get('/auction/{id}/bid-count', [AuctionBidController::class, 'bidCount']);
    Route::get('/auction/status-check', [AuctionController::class, 'statusCheck']);

    Route::get('/auction-winners', [AuctionWinnerController::class, 'index'])->name('auction.winners');
    Route::post('/auction-winners/{id}/approve', [AuctionWinnerController::class, 'approve'])->name('auction.winners.approve');
    Route::post('/auction-winners/{id}/reject',[AuctionWinnerController::class, 'reject'])->name('auction.winners.reject');

    //vehicle types
    Route::get('/vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types.index');
    Route::post('/vehicle-types', [VehicleTypeController::class, 'store'])->name('vehicle-types.store');
    Route::put('/vehicle-types/{id}', [VehicleTypeController::class, 'update'])->name('vehicle-types.update');
    Route::delete('/vehicle-types/{id}', [VehicleTypeController::class, 'destroy'])->name('vehicle-types.destroy');

    // admin users
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

});