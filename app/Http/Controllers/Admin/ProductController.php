<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection(Cache::remember('products', 60 * 60 * 24, function () {
            Product::with(['user', 'photos', 'categories'])->orderBy('created_at', 'ASC')->paginate(20);
        }));
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make(Cache::remember('product_show', 60 * 60 * 24, function () use ($product) {
            return $product;
        }));
    }

    public function update(Product $product, ProductRequest $request): ProductResource
    {
        $product->update($request->validated());

        return ProductResource::make($product);
    }

    public function destroy(Product $product): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $product->delete();

        return $this->index();
    }
}
