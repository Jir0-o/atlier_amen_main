<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TempCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Models\Category;
use App\Models\Work;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.landing');
});
Route::post('/logout', function () {
    return redirect()->route('frontend.login');
})->name('logout')->middleware('auth');
//frontend group
Route::prefix('cart')->group(function () {
    Route::get('/', [TempCartController::class, 'index'])->name('cart.index'); 
    Route::post('/add', [TempCartController::class, 'add'])->name('cart.add');
    Route::patch('/{tempCart}/quantity', [TempCartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/{tempCart}', [TempCartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/clear/all', [TempCartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/sync', [TempCartController::class, 'syncGuestCartStorage'])->name('cart.sync');
    Route::post('/cart/merge', [TempCartController::class, 'mergeGuestCartToUser'])->name('cart.merge');
    Route::get('/cart/count', [TempCartController::class, 'count'])->name('cart.count');
});

Route::get('/works/json/{work}', function (Work $work) {
    return response()->json([
        'id'               => $work->id,
        'name'             => $work->name,
        'price'            => $work->price,
        'work_image_low'   => $work->work_image_low,
    ]);
})->name('works.json');

Route::prefix('frontend')->group(function () {

    //resource routes
    Route::resource('contact-message', ContactMessageController::class);

    Route::get('/index', [FrontendController::class, 'index'])->name('index');
    Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
    Route::get('/exhibition', [FrontendController::class, 'exhibition'])->name('exhibition');
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::get('/login', [FrontendController::class, 'login'])->middleware('guest')->name('frontend.login');
    Route::get('/register', [FrontendController::class, 'register'])->middleware('guest')->name('frontend.register');
    Route::get('/password/reset', [FrontendController::class, 'resetPassword'])->middleware('guest')->name('frontend.password.request');
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::get('/workShow/{work}', [WorkController::class, 'workShow'])->name('frontend.works.show');
    


    Route::post('/register/store', [UserController::class, 'store'])
        ->middleware('guest')
        ->name('frontend.register.store');

    Route::post('/login/attempt', [UserController::class, 'login'])
        ->middleware(['guest', 'throttle:5,1'])
        ->name('login.attempt');

    // Show works in a category by slug
    Route::get('/works/{category:slug}', [CategoryController::class, 'category'])
        ->name('works.category');

    Route::get('/search/live', [CategoryController::class, 'liveSearch'])->name('search.live');



});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //resource routes
    Route::resource('categories', CategoryController::class);
    Route::resource('adminAbout', AboutController::class);
    Route::resource('adminContract', ContractController::class);
    Route::resource('works', WorkController::class);

    // gallery delete
    Route::delete('works/gallery/{id}', [WorkController::class, 'deleteGalleryImage'])->name('works.gallery.delete');

    //category make VIP
    Route::put('categories/{id}/make-vip', [CategoryController::class, 'makeVip'])->name('categories.make-vip');

    //work toggle feature
    Route::put('works/toggle-feature/{work}', [WorkController::class, 'toggleFeature'])->name('works.toggleFeature');

    //checkout routes
    Route::get('/checkout',  [CheckoutController::class, 'show'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    
    Route::get('/admin/contact-messages', [ContractController::class, 'Adminindex'])->name('contact-messages.index');
    Route::get('/admin/contact-messages/{id}', [ContractController::class, 'Adminshow'])->name('contact-messages.show');
    Route::delete('/admin/contact-messages/{id}', [ContractController::class, 'Admindestroy'])->name('contact-messages.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
