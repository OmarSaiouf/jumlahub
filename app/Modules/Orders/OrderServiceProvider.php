<?php

namespace App\Modules\Orders;

use App\Modules\Orders\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('order.service', OrderService::class);
       
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
