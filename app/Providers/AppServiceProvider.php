<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Product::observe(ProductObserver::class);

        view()->composer('layouts.app', function ($view) {
            $view->with('globalCategories', \App\Models\Category::active()
                ->withCount(['products as items_count' => function ($q) {
                    $q->active();
                }])
                ->orderByDesc('items_count')
                ->get());
        });
    }
}
