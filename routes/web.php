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
Route::get('/register', [LoginController::class, 'register'])->name('Frontend.register');