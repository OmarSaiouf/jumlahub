<?php

use App\Modules\Products\ProductsServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    ProductsServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
];
