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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Cache::remember('admin_categories', 60 * 60 * 24, function () {
            return Category::all();
        }));
    }

    public function store(CategoryRequest $request, CategoryService $service, Category $category = null): CategoryResource
    {
        return $service->create($request, $category);
    }

    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make(Cache::remember('admin_category_show', 60 * 60 * 24, function () use ($category) {
            return $category->loadMissing(['children' => function ($query) {
                $query->with('children');
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

    public function search(Request $request)
    {
        $categories = Category::where('name', 'like', '%' . $request->city_name . '%')->get();
        return response()->json(['data' => $categories]);
    }
}
