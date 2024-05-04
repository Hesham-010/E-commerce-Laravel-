<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoriesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Front Routes
Route::get('/', [FrontController::class,'home']);
Route::get('/home', [FrontController::class,'home'])->name('home');


Route::middleware('auth')->group(function (){
    Route::get('/shop', [FrontController::class,'shop'])->name('shop');
    Route::get('/show', [ProductsController::class,'show'])->name('show');

    // checkout Route
    Route::post('/{orderId}/checkout-session', [CheckoutController::class,'checkout_session'])->name('checkout-session');
    Route::get('/checkout-session/success', [CheckoutController::class,'success'])->name('checkout-session.success');

    // Order Routes
    Route::prefix('order')->group(function (){
        Route::get('/', [OrderController::class,'show'])->name('order.show');
        Route::post('/create', [OrderController::class,'create'])->name('order.create');
    });

    // Cart Routes
    Route::prefix('cart')->group(function (){
        Route::get('/', [CartController::class,'show'])->name('cart.show');
        Route::post('/add', [CartController::class,'add'])->name('cart.add');
        Route::get('/{productId}/delete', [CartController::class,'delete'])->name('cart.delete');
        Route::PUT('/update', [CartController::class,'update'])->name('cart.update');
        Route::post('/clear', [CartController::class,'clear'])->name('cart.clear');
    });

    // Wishlist Routes
    Route::prefix('wishlist')->group(function (){
        Route::get('/', [WishlistController::class,'index'])->name('wishlists');
        Route::get('/add', [WishlistController::class,'add'])->name('wishlist.add');
    });
});

// Admin Routs
Route::prefix('admin')->group(function (){
    Route::middleware('admin.guest')->group(function (){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    });

    Route::middleware('admin.auth')->group(function (){
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

        // Categories Routes
        Route::prefix('categories')->group(function (){
            Route::get('/',[CategoryController::class,'index'])->name('categories');
            Route::get('/create',[CategoryController::class,'create'])->name('categories.create');
            Route::post('/store',[CategoryController::class,'store'])->name('categories.store');
            Route::get('/{categoryId}/edit',[CategoryController::class,'edit'])->name('categories.edit');
            Route::PUT('/{categoryId}/update',[CategoryController::class,'update'])->name('categories.update');
            Route::get('/{categoryId}/delete',[CategoryController::class,'destroy'])->name('categories.delete');
        });

        // Sub Categories Routes
        Route::prefix('sub-categories')->group(function (){
            Route::get('/',[SubCategoriesController::class,'index'])->name('sub-categories');
            Route::get('/create',[SubCategoriesController::class,'create'])->name('sub-categories.create');
            Route::post('/store',[SubCategoriesController::class,'store'])->name('sub-categories.store');
            Route::get('/{subCategoryId}/edit',[SubCategoriesController::class,'edit'])->name('sub-categories.edit');
            Route::PUT('/{subCategoryId}/update',[SubCategoriesController::class,'update'])->name('sub-categories.update');
            Route::get('/{subCategoryId}/delete',[SubCategoriesController::class,'destroy'])->name('sub-categories.delete');
        });

        // Brands Routes
        Route::prefix('brands')->group(function (){
            Route::get('/',[BrandController::class,'index'])->name('brands');
            Route::get('/create',[BrandController::class,'create'])->name('brands.create');
            Route::post('/store',[BrandController::class,'store'])->name('brands.store');
            Route::get('/{brandId}/edit',[BrandController::class,'edit'])->name('brands.edit');
            Route::PUT('/{brandId}/update',[BrandController::class,'update'])->name('brands.update');
            Route::get('/{brandId}/delete',[BrandController::class,'destroy'])->name('brands.delete');
        });

        // Products Routes
        Route::prefix('products')->group(function (){
            Route::get('/',[ProductController::class,'index'])->name('products');
            Route::get('/create',[ProductController::class,'create'])->name('products.create');
            Route::post('/store',[ProductController::class,'store'])->name('products.store');
            Route::get('/{productId}/edit',[ProductController::class,'edit'])->name('products.edit');
            Route::PUT('/{productId}/update',[ProductController::class,'update'])->name('products.update');
            Route::get('/{productId}/delete',[ProductController::class,'destroy'])->name('products.destroy');

            Route::get('/product-subcategories',[ProductSubCategoryController::class,'index'])->name('product-subcategories.index');
        });

        // Coupons Routes
        Route::prefix('coupons')->group(function (){
            Route::get('/',[CouponController::class,'index'])->name('coupons');
            Route::get('/create',[CouponController::class,'create'])->name('coupons.create');
            Route::post('/store',[CouponController::class,'store'])->name('coupons.store');
            Route::get('/{couponId}/edit',[CouponController::class,'edit'])->name('coupons.edit');
            Route::PUT('/{couponId}/update',[CouponController::class,'update'])->name('coupons.update');
            Route::get('/{couponId}/destroy',[CouponController::class,'destroy'])->name('coupons.destroy');
        });
    });
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
