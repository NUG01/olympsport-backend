<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::with(['products', 'categories'])->get());
    }

    public function show(Brand $brand): BrandResource
    {
        return BrandResource::make($brand->loadMissing(['categories', 'products']));
    }
}
