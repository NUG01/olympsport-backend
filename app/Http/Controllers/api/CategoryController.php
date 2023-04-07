<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::whereNull('parent_id')->with(['children'])->get());
    }

    public function store(CategoryRequest $request): CategoryResource
    {
        $validated = $request->validated();
        $validated['slug'] = str_slug(preg_replace("/[\s-]+/", "_", $request->name), '_');
        $validated['parent_id'] = json_decode($request->parent_id, true);
        $category = Category::create($validated);

        return CategoryResource::make($category);
    }

    public function show(Category $category, Category $second_category = null, Category $third_category = null, Category $fourth_category = null, Category $fifth_category = null): CategoryResource
    {
        $categories = $category;

        if ($second_category && $third_category && $fourth_category && $fifth_category) {
            $categories = $fifth_category;
        } else if ($second_category && $third_category && $fourth_category) {
            $categories = $fourth_category;
        } else if ($second_category && $third_category) {
            $categories = $third_category;
        } else if ($second_category) {
            $categories = $second_category;
        }

        return CategoryResource::make($categories);
    }

    public function update(Category $category, CategoryRequest $request): CategoryResource
    {
        $validated = $request->validated();

        if ($request->parent_id !== null) {
            $parent_id = match ($category->parent_id) {
                null => json_decode($request->parent_id),
                default => array_merge($category->parent_id, json_decode($request->parent_id, true))
            };
            $validated['parent_id'] = $parent_id;
        }

        $validated['slug'] = str_slug(preg_replace("/[\s-]+/", "_", $request->name), '_');
        $category->update($validated);

        return CategoryResource::make($category);
    }

    public function destroy(Category $category): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        CategoryResource::destroy($category);

        return CategoryResource::collection(Category::all());
    }
}
