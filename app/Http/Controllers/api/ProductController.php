<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection(Product::with(['user', 'photos'])->get());
    }

    public function store(ProductRequest $request): ProductResource
    {
        $photos = $request->file('photos')->store('product_images');

        $validated = $request->validated();
        $validated['photos'] = $photos;

        $product = Product::photos()->create($validated);

        return ProductResource::make($product);
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
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
