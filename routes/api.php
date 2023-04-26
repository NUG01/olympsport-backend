<?php

use App\Http\Controllers\{Admin\WebsiteAssetController,
    api\BrandController,
    api\CategoryController,
    api\SubscriptionController,
    api\ProductController,
};
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories.index');
    Route::get('/category/{category}', 'show')->name('categories.show');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('/brands', 'index')->name('brands.index');
    Route::get('/brand/{brand}', 'show')->name('brands.show');
});

Route::get('/cities', fn() => CityResource::collection(City::all()));

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::post('/product/store', 'store')->name('products.store');
    Route::get('/product/{product}', 'show')->name('products.show');
    Route::patch('/product/update/{product}', 'update')->name('products.update');
    Route::delete('/product/delete/{product}', 'destroy')->name('products.destroy');
});

Route::controller(WebsiteAssetController::class)->group(function () {
    Route::get('/about_us', 'aboutUs')->name('about_us');
    Route::get('/terms_and_conditions', 'aboutUs')->name('terms_and_conditions');
});

Route::controller(SubscriptionController::class)->group(function () {
    Route::post('/subscribe', 'subscribe')->name('subscription');
    Route::get('/user_intent', 'userIntent/{plan}')->name('user-intent');
});

Route::get('/product_assets', fn() => response()->json(config('product-assets')));

require_once __DIR__ . '/./auth.php';
require_once __DIR__ . '/./admin.php';
