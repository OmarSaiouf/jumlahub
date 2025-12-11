<?php

namespace App\Modules\Products\Facades;

use Illuminate\Support\Facades\Facade;

class CategoryFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'categories.service';
    }
}