<?php

use App\Http\Controllers\Admin\WebsiteAssetController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PlanController;
use App\Http\Controllers\api\ProductController;
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

Route::get('/cities', fn () => CityResource::collection(City::all()));

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::post('/product/store', 'store')->name('products.store');
    Route::get('/product/{product}', 'show')->name('products.show');
    Route::patch('/product/update/{product}', 'update')->name('products.update');
    Route::delete('/product/delete/{product}', 'destroy')->name('products.destroy');
});

Route::controller(WebsiteAssetController::class)->group(function (){
    Route::get('/about_us', 'aboutUs')->name('admin.about_us');
    Route::get('/terms_and_conditions', 'aboutUs')->name('admin.terms_and_conditions');
});

Route::get('/product_assets', fn () => response()->json(config('product-assets')));

Route::post('subscription', [PlanController::class, 'subscription'])->name('subscription');

require_once __DIR__ . '/./auth.php';
require_once __DIR__ . '/./admin.php';
