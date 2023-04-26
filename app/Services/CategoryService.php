<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function create(CategoryRequest $request, Category $category = null): CategoryResource
    {
        $data = [
            'name' => $request->name,
            'slug' => str_slug($request->name, '_'),
        ];

        if ($category) {
            $data['slug'] = $category->slug . '_' . str_slug($request->name, '_');
            $data['parent_id'] = [$category->id];
        }

        $created_category = Category::create($data);

        if ($category) {
            $created_category = $category;
        }

        return CategoryResource::make($created_category);
    }

    public function update(Category $category, CategoryRequest $request): CategoryResource
    {
        $validated = $request->validated();
        $validated['parent_id']= $request->parent_id;

        $slug = str_slug(preg_replace("/[\s-]+/", "_", $request->name), '_');

        $slugsArray = Category::where('slug', 'LIKE', '%' . $category->slug . '%')->get();

        foreach ($slugsArray as $slugs) {
            $slugs->slug = str_replace($category->slug, $slug, $slugs->slug);
            $slugs->update();
        }

        $validated['slug'] = $slug;
        $category->update($validated);

        return CategoryResource::make($category);
    }
}
