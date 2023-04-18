<?php

use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Resources\CityResource;
use App\Models\City;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories.index');
    Route::post('/category/store/{category?}', 'store')->name('categories.store');
    Route::get('/category/{category}', 'show')->name('categories.show');
    Route::patch('/category/update/{category}', 'update')->name('categories.update');
    Route::delete('/category/delete/{category}', 'destroy')->name('categories.destroy');
});

Route::get('/cities', fn() => CityResource::collection(City::all()));

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::post('/product/store', 'store')->name('products.store');
    Route::get('/product/{product}', 'show')->name('products.show');
    Route::patch('/product/update/{product}', 'update')->name('products.update');
    Route::delete('/product/delete/{product}', 'destroy')->name('products.destroy');
});

Route::get('/product_assets', fn() => response()->json(config('product-assets')));

require_once __DIR__ . '/auth.php';
