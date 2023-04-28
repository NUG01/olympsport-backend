<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addRemoveFavorite($productId, $token = null)
    {
        if (Auth::user()) $token = Auth::user()->id;

        $checkFavoriteStatus = Favorite::where('user_id', $token)->where('product_id', $productId);

        if ($checkFavoriteStatus->first()) {
            $checkFavoriteStatus->delete();

            return response()->json('Deleted!');
        }

        Favorite::create([
            'user_id' => $token,
            'product_id' => $productId
        ]);
        return response()->json('Created!');
    }


    public function index($token = null)
    {
        if (Auth::user()) $token = Auth::user()->id;
        $favoriteProductIds = Favorite::where('user_id', $token)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();
        return ProductResource::collection($favoriteProducts);
    }
}
