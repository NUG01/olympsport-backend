<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Resources\CityResource;
use App\Models\City;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::post('/category/store', 'store');
    Route::get('/category/{category}/{second_category?}/{third_category?}/{fourth_category?}/{fifth_category?}', 'show');
    Route::patch('/category/update/{category}', 'update');
    Route::delete('/category/delete/{category}', 'destroy');
});

Route::get('/cities', fn() => CityResource::collection(City::all()));
