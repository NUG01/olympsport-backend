<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::all());
    }

    public function store(BrandRequest $request): BrandResource
    {
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => str_slug($request->name, '_'),
            'category_id' => $request->category_id,
        ]);

        return BrandResource::make($brand);
    }

    public function show(Brand $brand): BrandResource
    {
        return BrandResource::make($brand);
    }

    public function update()
    {

    }

    public function destroy(Brand $brand): AnonymousResourceCollection
    {
        $brand->delete();

        return BrandResource::collection(Brand::all());
    }
}
