<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::with(['products', 'categories'])->get());
    }

    public function store(BrandRequest $request): BrandResource
    {
        $category_id = $request->category_id ? [(integer)$request->category_id] : null;

        $validated = $request->validated();

        $validated['slug'] = str_slug($request->name, '_');
        $validated['category_id'] = $category_id;

        $brand = Brand::create($validated);

        return BrandResource::make($brand);
    }

    public function show(Brand $brand): BrandResource
    {
        return BrandResource::make($brand->loadMissing(['categories', 'products']));
    }

    public function showCategoryList(Request $request, Brand $brand): JsonResponse
    {
        return response()->json(Category::where('name', 'LIKE', $request->name . '%')->whereNotIn('id', $brand->category_id)->get()->makeHidden('parent_id'));
    }

    public function brandCategories(Brand $brand): JsonResponse
    {
        return response()->json(Category::whereIn('id', $brand->category_id)->get()->makeHidden('parent_id'));
    }

    public function update(BrandRequest $request, Brand $brand): BrandResource
    {
        $category_id = $request->category_id ? [(integer)$request->category_id] : null;

        $validated = $request->validated();
        $validated['slug'] = str_slug(preg_replace("/[\s-]+/", "_", $request->name), '_');
        $validated['category_id'] = array_merge($brand->category_id, $category_id);

        $brand->update($validated);

        return BrandResource::make($brand);
    }

    public function removeCategory(Brand $brand, $id)
    {
        $array = $brand->category_id;
        foreach (array_keys($array, (int)$id) as $key) {
            unset($array[$key]);
            $brand->update(['category_id' => array_values($array)]);
        }
    }

    public function destroy(Brand $brand): Response
    {
        $brand->delete();

        return response()->noContent();
    }
}
