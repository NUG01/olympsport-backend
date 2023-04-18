<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('categories', 60 * 60 * 24, function () {
            return Category::with('children')->whereNull('parent_id')->get();
        }));
    }

    public function store(CategoryRequest $request, Category $category = null): CategoryResource
    {
        $data = [
            'name' => $request->name,
            'slug' => $category->slug . '_' . str_slug($request->name, '_'),
        ];

        if ($category !== null) {
            $data['parent_id'] = [$category->id];
        }

        Category::create($data);

        return CategoryResource::make($category);
    }

    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make(Cache::remember('category_show', 60 * 60 * 24, function () use ($category) {
            return $category->loadMissing('children');
        }));
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
        $category->delete();

        return CategoryResource::collection(Category::all());
    }
}
