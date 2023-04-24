<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection(Cache::remember('products', 60 * 60 * 24, function () {
            Product::with(['user', 'photos', 'categories'])->orderBy('boosted', 'DESC')->orderBy('created_at', 'ASC')->get();
        }));
    }

    public function store(ProductRequest $request, ProductService $service): ProductResource
    {
        return $service->create($request);
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make(Cache::remember('product_show', 60 * 60 * 24, function () use ($product) {
            return $product;
        }));
    }

    public function update(Product $product, ProductRequest $request, ProductService $service): ProductResource
    {
       return  $service->update($product, $request);
    }

    public function destroy(Product $product): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $product->delete();

        return $this->index();
    }
}
