<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Cache::forget('categories');
        Cache::forget('category_show');
    }

    public function updated(Category $category): void
    {
        Cache::forget('categories');
        Cache::forget('category_show');
    }

    public function deleted(Category $category): void
    {
        Cache::forget('categories');
        Cache::forget('category_show');
    }
}

