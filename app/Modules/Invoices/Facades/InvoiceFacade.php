<?php

namespace App\Modules\Invoices\Facades;

use Illuminate\Support\Facades\Facade;

class InvoiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'invoice.service';
    }
}

