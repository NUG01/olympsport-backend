<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
    }

    public function updated(Category $category): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
    }

    public function deleted(Category $category): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
    }
}

