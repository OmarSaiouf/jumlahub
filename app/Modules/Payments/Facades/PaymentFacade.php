<?php

namespace App\Modules\Payments\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "payment.service";
    }
}