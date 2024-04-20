<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


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
    });
});
