<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('admin_categories', 60 * 60 * 24, function () {
            return Category::with('children.children', 'products')->whereNull('parent_id')->get();
        }));
    }

    public function store(CategoryRequest $request, CategoryService $service, Category $category = null): CategoryResource
    {
        return $service->create($request, $category);
    }

    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category->loadMissing(['children' => function ($query) {
            $query->with('children');
        }])
        );
    }

    public function update(Category $category, CategoryRequest $request, CategoryService $service): CategoryResource
    {
        return $service->update($category, $request);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }

    public function search(Request $request): JsonResponse
    {
        $categories = Category::where('name', 'like', '%' . $request->name . '%')->orWhere('slug', 'like', '%' . $request->name . '%')->get();
        return response()->json(['data' => $categories]);
    }
}
