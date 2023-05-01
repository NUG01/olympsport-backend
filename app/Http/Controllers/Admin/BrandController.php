<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::with(['products', 'categories'])->get());
    }

    public function store(BrandRequest $request): BrandResource
    {
        $validated = $request->validated();
        $validated['slug'] = str_slug($request->name, '_');

        return BrandResource::make($validated);
    }

    public function show(Brand $brand): BrandResource
    {
        return BrandResource::make($brand->loadMissing(['categories', 'products']));
    }

    public function update(Brand $brand, BrandRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = str_slug(preg_replace("/[\s-]+/", "_", $request->name), '_');

        $brand->update($request->validated());
    }

    public function destroy(Brand $brand)
    {

        $brand->delete();

        return response()->noContent();
    }
}
