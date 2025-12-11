<?php

namespace App\Modules\Products;

use App\Modules\Products\Services\CategoryService;
use App\Modules\Products\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton("categories.service", CategoryService::class);
        $this->app->singleton("products.service", ProductService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
