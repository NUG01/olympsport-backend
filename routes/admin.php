<?php

use App\Http\Controllers\api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WebsiteAssetController;

Route::prefix('admin')->group(function () {
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/users', 'index')->name('admin.users.index');
        Route::get('/users/{user}', 'get')->name('admin.users.get');
        Route::post('/users/status', 'setStatus')->name('admin.users.status');
        Route::delete('/users/delete/{user}', 'destroy')->name('admin.users.destroy');
        Route::post('/users/edit/{user}', 'update')->name('admin.users.edit');
    });


    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('admin.categories.index');
        Route::post('/category/store/{category?}', 'store')->name('admin.categories.store');
        Route::get('/category/{category}', 'show')->name('admin.categories.show');
        Route::patch('/category/update/{category}', 'update')->name('admin.categories.update');
        Route::delete('/category/delete/{category}', 'destroy')->name('admin.categories.destroy');
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('/brands', 'index')->name('admin,brands.index');
        Route::post('/brand/store', 'store')->name('admin.brands.store');
        Route::patch('/brand/update/{brand}', 'update')->name('admin.brands.update');
        Route::delete('/brand/delete/{brand}', 'delete')->name('admin.brands.delete');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('admin.products.index');
        Route::get('/product/{product}', 'show')->name('admin.products.show');
        Route::patch('/product/update/{product}', 'update')->name('admin.products.update');
        Route::delete('/product/delete/{product}', 'destroy')->name('admin.products.destroy');
    });

    Route::controller(WebsiteAssetController::class)->group(function () {
        Route::get('/terms_and_conditions', 'aboutUs')->name('admin.terms_and_conditions');
        Route::get('/about_us', 'aboutUs')->name('admin.about_us');
        Route::patch('/update/website_assets/{id}', 'update')->name('admin.update.website_assets');
    });
});
