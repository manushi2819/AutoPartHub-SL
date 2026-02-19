<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('Frontend.index');
Route::get('/about-us', [HomeController::class, 'about'])->name('Frontend.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('Frontend.contact');

Route::get('/shop', [ShopController::class, 'index'])->name('Frontend.shop');

Route::get('/login', [LoginController::class, 'login'])->name('Frontend.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('Frontend.login.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('Frontend.register');
Route::post('/register', [LoginController::class, 'store'])->name('Frontend.register.store');
Route::post('/customer/logout', [LoginController::class, 'logout'])->name('Frontend.logout');

Route::prefix('customer')->name('customer.')->middleware('auth:customer')->group(function () {

    Route::get('dashboard', function () {
        return view('Frontend.account');
    })->name('dashboard');


});














// admin login
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Middleware\AdminAuth;

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->name('admin.')->middleware([AdminAuth::class])->group(function () {

    Route::get('/', function () {
        return view('AdminDashboard.index');
    })->name('dashboard');


});