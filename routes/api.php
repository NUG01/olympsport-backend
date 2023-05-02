<?php

use App\Http\Controllers\{
    Admin\WebsiteAssetController,
    api\BrandController,
    api\CategoryController,
    api\FavoriteController,
    api\ProductController,
    api\ProfileController,
    api\SubscriptionController
};
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    Route::get('/products/{token?}', 'index')->name('products.index');
    Route::post('/product/store', 'store')->name('products.store');
    Route::get('/product/{product}/{token?}', 'show')->middleware('is_seeker')->name('products.show');
    Route::patch('/product/update/{product}', 'update')->middleware('is_seeker')->name('products.update');
    Route::delete('/product/delete/{product}', 'destroy')->middleware('is_seeker')->name('products.destroy');
    Route::get('/products/by_brands/{brand}/{token?}', 'byBrand')->name('products.byBrand');
});

Route::controller(WebsiteAssetController::class)->group(function () {
    Route::get('/about_us', 'aboutUs')->name('about_us');
    Route::get('/terms_and_conditions', 'aboutUs')->name('terms_and_conditions');
});

Route::controller(SubscriptionController::class)->middleware('is_seeker')->group(function () {
    Route::post('/subscribe', 'subscribe')->name('subscription');
    Route::get('/user_intent', 'userIntent/{plan}')->name('user-intent');
});

Route::controller(FavoriteController::class)->group(function () {
    Route::get('/favorite-products/{token?}', 'index')->name('favorite.index');
    Route::post('/favorite/{productId}/{token?}', 'addRemoveFavorite')->name('favorite.addRemoveFavorite');
});

Route::controller(ProfileController::class)->middleware(['auth:sanctum', 'is_seeker'])->group(function () {
    Route::get('/user/{user}', 'user')->name('user.profile');
    Route::patch('/user/update/{user}', 'update')->name('user.profile.update');
    Route::get('/user/products/{user}', 'products')->name('user.products');
    Route::get('/user/cancel_subscription/{user}', 'cancelSubscription')->name('user.cancelSubscription');
    Route::delete('/user/delete/{user}', 'destroy')->name('user.delete');
});

Route::get('/product_assets', fn () => response()->json(config('product-assets')));

Route::prefix('/admin')->middleware('is_admin')->group(function () {
    require_once __DIR__ . '/./admin.php';
});

require_once __DIR__ . '/./auth.php';
