<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FooterSettingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopFeatureController;
use App\Http\Controllers\TempCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WorkController;
use App\Models\Category;
use App\Models\Work;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.landing');
})->name('frontend.landing');
Route::post('/logout', function () {
    return redirect()->route('frontend.login');
})->name('logout')->middleware('auth');
//frontend group
Route::prefix('cart')->group(function () {
    Route::get('/', [TempCartController::class, 'index'])->name('cart.index'); 
    Route::post('/buy-now', [TempCartController::class, 'buyNow'])->middleware('feature:buy_now_enabled')->name('cart.buyNow');
    Route::post('/add', [TempCartController::class, 'add'])->middleware('feature:cart_enabled')->name('cart.add');
    Route::patch('/{tempCart}/quantity', [TempCartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/{tempCart}', [TempCartController::class, 'destroy'])->middleware('feature:cart_enabled')->name('cart.destroy');
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
    Route::get('/shop', [FrontendController::class, 'shop'])->middleware('feature:shop_enabled')->name('shop');
    Route::get('/shop/data', [FrontendController::class, 'shopData'])->name('frontend.shop.data');
    Route::get('/exhibition', [FrontendController::class, 'exhibition'])->name('exhibition');
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::get('/login', [FrontendController::class, 'login'])->middleware('guest')->name('frontend.login');
    Route::get('/register', [FrontendController::class, 'register'])->middleware('guest')->name('frontend.register');
    Route::get('/password/reset', [FrontendController::class, 'resetPassword'])->middleware('guest')->name('frontend.password.request');
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('feature:wishlist_enabled')->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->middleware('feature:wishlist_enabled')->name('wishlist.add'); 
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])
        ->middleware('feature:wishlist_enabled')
        ->name('wishlist.remove');
    Route::delete('/wishlist/work/{work}', [WishlistController::class, 'removePage'])
        ->middleware('feature:wishlist_enabled')
        ->name('wishlist.remove.work');
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

Route::middleware('auth')->group(function () {

    //resource routes
    Route::resource('categories', CategoryController::class);
    Route::resource('adminAbout', AboutController::class);
    Route::resource('adminContract', ContractController::class);
    Route::resource('works', WorkController::class);
    Route::resource('users', UserController::class);


    //dashbaord routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //user routs
    Route::get('/admin/users/data', [UserController::class, 'data'])->name('admin.users.data');
    Route::patch('/admin/users/{user}/toggle', [UserController::class, 'toggle'])->name('admin.users.toggle');

    //account settings update routes
    Route::post('/profile/settings/profile',  [ProfileController::class, 'updateProfile'])->name('account.settings.profile');
    Route::post('/profile/settings/password', [ProfileController::class, 'changePassword'])->name('account.settings.password');
    Route::post('/profile/settings/email',    [ProfileController::class, 'changeEmail'])->name('account.settings.email');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account/orders/{order}', [ProfileController::class, 'showOrder'])->name('account.orders.show');

    //account address routes
    Route::post('/account/address/shipping', [AddressController::class, 'upsertShipping'])
        ->name('account.address.shipping.upsert');
    Route::post('/account/address/billing', [AddressController::class, 'upsertBilling'])
        ->name('account.address.billing.upsert');
 
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

    
    Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/data', [OrderController::class, 'data'])->name('data');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show'); 
        Route::post('/{order}/accept', [OrderController::class, 'accept'])->name('accept');
        Route::post('/{order}/reject', [OrderController::class, 'reject'])->name('reject');
    });

    // Admin footer settings
    Route::get('/admin/footer-settings', [FooterSettingController::class, 'index'])->name('admin.footer.settings.index');
    Route::get('/admin/footer-settings/data', [FooterSettingController::class, 'data'])->name('admin.footer.settings.data');
    Route::get('/admin/footer-settings/show', [FooterSettingController::class, 'show'])->name('admin.footer.settings.show');
    Route::patch('/admin/footer-settings/update', [FooterSettingController::class, 'update'])->name('admin.footer.settings.update');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('attributes', AttributeController::class);
        Route::resource('attribute-values', AttributeValueController::class);
        Route::get('/shop-features', [ShopFeatureController::class, 'edit'])->name('shop.features.edit');
        Route::post('/shop-features', [ShopFeatureController::class, 'update'])->name('shop.features.update');
    });
});

require __DIR__.'/auth.php';
