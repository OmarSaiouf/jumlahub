<?php

use App\Modules\Invoices\InvoiceEventServiceProvider;
use App\Modules\Invoices\InvoiceServiceProvider;
use App\Modules\Orders\OrderEventServiceProvider;
use App\Modules\Orders\OrderServiceProvider;
use App\Modules\Payments\PaymentServiceProvider;
use App\Modules\Products\ProductsServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\TelescopeServiceProvider;

return [
        // main application service providers...
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    TelescopeServiceProvider::class,
        // order module service providers...
    OrderServiceProvider::class,
    OrderEventServiceProvider::class,
        // invoice module service providers...
    InvoiceServiceProvider::class,
    InvoiceEventServiceProvider::class,
        // products and payments service providers...
    ProductsServiceProvider::class,
        // payments module service providers...
    PaymentServiceProvider::class,
];
