<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('categories', 60 * 60 * 24, function () {
            return Category::whereNull('parent_id')->get();
        }));
    }

    public function store(CategoryRequest $request, CategoryService $service, Category $category = null): CategoryResource
    {
        return $service->create($request, $category);
    }

    public function show(Category $category): AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('category_show', 60 * 60 * 24, function () use ($category) {
            return $category->loadMissing(['products', 'children' => function ($query) {
                $query->with('children', 'products');
            }]);
        }));
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
}
