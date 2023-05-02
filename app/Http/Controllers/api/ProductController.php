<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductService $service, $token = null): AnonymousResourceCollection
    {
        return $service->index($token);
    }

    public function byBrand(ProductService $service, Brand $brand, $token = null): AnonymousResourceCollection
    {
        return $service->byBrand($brand, $token);
    }

    public function store(ProductRequest $request, ProductService $service): ProductResource
    {
        return $service->create($request);
    }

    public function show(Product $product, ProductService $service, $token = null): ProductResource
    {
        return $service->show($product, $token);
    }

    public function update(Product $product, ProductRequest $request, ProductService $service): ProductResource
    {
        return $service->update($product, $request);
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }
}
