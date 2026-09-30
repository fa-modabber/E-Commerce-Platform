<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Shop;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ----------------------------------------
        // Dashboard Routes
        // ----------------------------------------
        Route::get('/', [Admin\HomeController::class, 'index'])
        ->name('dashboard');


        // ----------------------------------------
        // Slider Routes
        // ----------------------------------------
        Route::prefix('sliders')->name('sliders.')->group(function () {
            Route::resource('/', Admin\SliderController::class)
                ->parameters(['' => 'slider'])
                ->except(['show']);
        });


        // ----------------------------------------
        // Feature Routes
        // ----------------------------------------
        Route::prefix('features')->name('features.')->group(function () {
            Route::resource('/', Admin\FeatureController::class)
                ->parameters(['' => 'feature'])
                ->except(['show']);
        });

        // ----------------------------------------
        // About us Routes
        // ----------------------------------------
        Route::singleton('about-us', Admin\AboutUsController::class);


        // ----------------------------------------
        // Contact us Routes
        // ----------------------------------------
        Route::prefix('contact-us')
            ->controller(Admin\ContactUsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('contact-us.index');
                Route::get('/{contact}', 'show')->name('contact-us.show');
                Route::delete('/{contact}', 'destroy')->name('contact-us.destroy');
            });

        // ----------------------------------------
        // Footer Routes
        // ----------------------------------------
        Route::singleton('footer', Admin\FooterController::class);

        // ----------------------------------------
        // Category Routes
        // ----------------------------------------
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::resource('/', Admin\CategoryController::class)
                ->parameters(['' => 'category'])
                ->except('show');
        });

        // ----------------------------------------
        // Product Routes
        // ----------------------------------------
        Route::prefix('products')->name('products.')->group(function () {
            Route::resource('/', Admin\ProductController::class)
                ->parameters(['' => 'product']);
        });

        // ----------------------------------------
        // Coupon Routes
        // ----------------------------------------
        Route::prefix('coupons')->name('coupons.')->group(function () {
            Route::resource('/', Admin\CouponController::class)
                ->parameters(['' => 'coupon'])
                ->except(['show']);
        });
    });


/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('Shop.home.index');
})->name('home');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', [Shop\ContactUsController::class, 'index'])->name('contact-us.index');
    Route::post('/', [Shop\ContactUsController::class, 'Shop'])->name('contact-us.Shop');
});

Route::get('/products/{product:slug}', [Shop\ProductController::class, 'show'])->name('products.show');
Route::get('/menu', [Shop\ProductController::class, 'menu'])->name('products.menu');


Route::middleware('guest')->group(function () {
    Route::get('/login', [Shop\AuthController::class, 'loginForm'])->name('auth.loginForm');
    Route::post('/login', [Shop\AuthController::class, 'login'])->name('auth.login');
    Route::post('/check-otp', [Shop\AuthController::class, 'check_otp'])->name('auth.check-otp');
    Route::post('/resend-otp', [Shop\AuthController::class, 'resend_otp'])->name('auth.resend-otp');
});

Route::get('/logout', [Shop\AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');


Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [Shop\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/{user}', [Shop\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/addresses', [Shop\ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::get('/addresses/create', [Shop\ProfileController::class, 'address_create'])->name('profile.addresses.create');
    Route::post('/addresses', [Shop\ProfileController::class, 'address_Shop'])->name('profile.addresses.Shop');
    Route::get('/addresses/{address}/edit', [Shop\ProfileController::class, 'address_edit'])->name('profile.addresses.edit');
    Route::put('/addresses/{address}', [Shop\ProfileController::class, 'address_update'])->name('profile.addresses.update');
    Route::get('/wishlist', [Shop\ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::get('/wishlist-remove', [Shop\ProfileController::class, 'remove_from_wishlist'])->name('profile.wishlist.remove');
    Route::get('/wishlist-add-to', [Shop\ProfileController::class, 'wishlist_add_to'])->name('profile.wishlist.add');
});


Route::prefix('cart')->middleware('auth')->group(function () {
    Route::get('/', [Shop\CartController::class, 'index'])->name('cart.index');
    Route::get('/decrement', [Shop\CartController::class, 'decrement'])->name('cart.decrement');
    Route::get('/add', [Shop\CartController::class, 'add'])->name('cart.add');
    Route::get('/clear', [Shop\CartController::class, 'clear'])->name('cart.clear');
    Route::post('/checkCoupon', [Shop\CartController::class, 'checkCoupon'])->name('cart.check-coupon');
});
