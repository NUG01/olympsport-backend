<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Subscription;
use App\Models\SubscriptionItem;
use App\Models\User;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
    }
}
