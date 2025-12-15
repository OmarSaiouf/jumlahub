<?php

namespace App\Modules\Invoices;

use App\Modules\Invoices\Services\InvoiceService;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton("invoice.service", InvoiceService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
