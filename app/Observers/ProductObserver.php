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
    }

    public function updated(Product $product): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
    }

    public function deleted(Product $product): void
    {
        Cache::forget('products');
        Cache::forget('product_show');
        Cache::forget('categories');
        Cache::forget('admin_categories');
    }
}
