<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function created(Product $product): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
        Cache::forget('category_show');
        Cache::forget('admin_category_show');
    }

    public function updated(Product $product): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
        Cache::forget('category_show');
        Cache::forget('admin_category_show');
    }

    public function deleted(Product $product): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
        Cache::forget('category_show');
        Cache::forget('admin_category_show');
    }
}
