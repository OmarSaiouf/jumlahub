<?php

namespace App\Modules\Payments\Services;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class PaymentServiceEventProvider extends EventServiceProvider
{
    protected $listen = [
    ];

    public function boot(): void
    {
        parent::boot();
    }
}