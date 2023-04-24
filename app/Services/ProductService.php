<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function create(ProductRequest $request): \App\Http\Resources\ProductResource
    {
        $photos = $request->file('photos')->store('product_images');

        $validated = $request->validated();
        $validated['photos'] = $photos;

        $product = Product::create($validated);

        $product_id = match (Auth::user()->product_id) {
            null => (array)$product->id,
            default => array_merge(Auth::user()->product_id, (array)$product->id),
        };

        Auth::user()->update(['product_id' => $product_id,]);

        return ProductResource::make($product);
    }

    public function update(Product $product, ProductRequest $request): ProductResource
    {
        $validated = $request->validated();

        $logoPath = $product->photos();

        if ($request->file('logo')) $logoPath = $request->file('photos')->store('product_images');

        $validated['photos'] = $logoPath;

        $product->update($request->validated());

        return ProductResource::make($product);
    }
}
