<?php

use App\Http\Controllers\Admin\{
    CategoryController,
    UserController as AdminUserController,
    WebsiteAssetController,
    BrandController,
    ProductController,
};
use Illuminate\Support\Facades\Route;

Route::controller(AdminUserController::class)->group(function () {
    Route::get('/users', 'index')->name('admin.users.index');
    Route::get('/users/{user}', 'get')->name('admin.users.get');
    Route::post('/users/status', 'setStatus')->name('admin.users.status');
    Route::delete('/users/delete/{user}', 'destroy')->name('admin.users.destroy');
    Route::post('/users/edit/{user}', 'update')->name('admin.users.edit');
    Route::post('/users/cities', 'searchCities')->name('admin.users.search.cities');
    Route::get('/users/city/{city}', 'getCity')->name('admin.users.city');
    Route::post('/password/update', 'editPassword')->name('admin.password.update');
    Route::post('/cancel_subscription', 'cancelSubscription')->name('admin.user.cancel.subscription');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('admin.categories.index');
    Route::post('/category/store/{category?}', 'store')->name('admin.categories.store');
    Route::get('/category/{category:id}', 'show')->name('admin.categories.show');
    Route::patch('/category/update/{category:id}', 'update')->name('admin.categories.update');
    Route::delete('/category/delete/{category}', 'destroy')->name('admin.categories.destroy');
    Route::post('/category/search', 'search')->name('admin.categories.search');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('/brands', 'index')->name('admin.brands.index');
    Route::get('/brand/{brand:id}', 'show')->name('admin.brands.show');
    Route::post('/brand/store', 'store')->name('admin.brands.store');
    Route::patch('/brand/update/{brand:id}', 'update')->name('admin.brands.update');
    Route::post('/brand/category_list/{brand:id}', 'showCategoryList')->name('admin.brands.categoryList');
    Route::delete('/brand/remove_category/{brand:id}/{id}', 'removeCategory')->name('admin.brands.removeCategory');
    Route::delete('/brand/delete/{brand:id}', 'delete')->name('admin.brands.delete');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('admin.products.index');
    Route::get('/product/{product:id}', 'show')->name('admin.products.show');
    Route::patch('/product/update/{product}', 'update')->name('admin.products.update');
    Route::delete('/product/delete/{product}', 'destroy')->name('admin.products.destroy');
});

Route::controller(WebsiteAssetController::class)->group(function () {
    Route::get('/terms_and_conditions', 'termsAndConditions')->name('admin.terms_and_conditions');
    Route::get('/about_us', 'aboutUs')->name('admin.about_us');
    Route::patch('/update/website_assets/{id}', 'update')->name('admin.update.website_assets');
});
