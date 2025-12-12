<?php

namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentProviderFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'payment.provider.service';
    }
}