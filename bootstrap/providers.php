<?php

use App\Modules\Invoices\InvoiceEventServiceProvider;
use App\Modules\Invoices\InvoiceServiceProvider;
use App\Modules\Orders\OrderServiceProvider;
use App\Modules\Payments\PaymentServiceProvider;
use App\Modules\Products\ProductsServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\TelescopeServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    ProductsServiceProvider::class,
    OrderServiceProvider::class,
    TelescopeServiceProvider::class,
    PaymentServiceProvider::class,
    InvoiceServiceProvider::class,
    InvoiceEventServiceProvider::class,
];
