<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('categories', 60 * 60 * 24, function () {
            return Category::with(['children', 'products'])->whereNull('parent_id')->get();
        }));
    }

    public function show(Category $category): AnonymousResourceCollection
    {
        return CategoryResource::collection(Cache::remember('category_show', 60 * 60 * 24, function () use ($category) {
            return $category->loadMissing(['products', 'children' => function ($query) {
                $query->with('children', 'products');
            }]);
        }));
    }
}
