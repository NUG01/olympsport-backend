<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\BrandProducts;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function index($token = null): AnonymousResourceCollection
    {
        if (Auth::user()) $token = Auth::user()->id;

        return ProductResource::customCollection(Cache::remember('products', 60 * 60 * 24, function () {
            return Product::with(['user', 'photos', 'categories', 'favorite'])->orderBy('boosted', 'DESC')->latest()->get();
        }), $token);
    }

    public function show(Product $product, $token = null): ProductResource
    {
        if (Auth::user()) $token = Auth::user()->id;

        return ProductResource::customMake($product->load(['categories', 'user', 'photos']), $token);
    }

    public function create(ProductRequest $request): ProductResource
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

    public function byBrand(Brand $brand, $token = null): AnonymousResourceCollection
    {
        if (Auth::user()) $token = Auth::user()->id;

        $ids = BrandProducts::with('products')->where('brand_id', $brand->id)->pluck('product_id');

        return ProductResource::customCollection(Product::whereIn('id', $ids)->with('brand')->get(), $token);
    }
}
