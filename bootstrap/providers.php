<?php

use App\Modules\Orders\OrderServiceProvider;
use App\Modules\Products\ProductsServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    ProductsServiceProvider::class,
    OrderServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
];
