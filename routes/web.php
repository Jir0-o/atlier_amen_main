<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.landing');
});

//frontend group
Route::prefix('frontend')->group(function () {
    Route::get('/index', [FrontendController::class, 'index'])->name('index');
    Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
    Route::get('/exhibition', [FrontendController::class, 'exhibition'])->name('exhibition');
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::get('/login', [FrontendController::class, 'login'])->name('frontend.login');
    Route::get('/register', [FrontendController::class, 'register'])->name('frontend.register');
    Route::get('/password/reset', [FrontendController::class, 'resetPassword'])->name('frontend.password.request');
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
