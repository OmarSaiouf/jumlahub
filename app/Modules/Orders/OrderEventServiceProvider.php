<?php

namespace App\Modules\Orders;

use App\Modules\Orders\listeners\MarkOrderAsPaid;
use App\Modules\Payments\Events\PaymentCompleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class OrderEventServiceProvider extends EventServiceProvider
{

    protected $listen = [
        PaymentCompleted::class => [
            MarkOrderAsPaid::class,
        ],
    ];
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
