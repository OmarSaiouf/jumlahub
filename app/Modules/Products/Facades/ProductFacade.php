<?php

namespace App\Modules\Products\Facades;

use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'products.service';
    }
}