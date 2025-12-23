<?php

namespace App\Core\Services;

use App\Core\Models\PaymentProvider;

class PaymentProviderService
{

    public function all()
    {
        return PaymentProvider::where('is_active', true);
    }
}