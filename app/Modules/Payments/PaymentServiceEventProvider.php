<?php

namespace App\Modules\Payments\Services;

use App\Modules\Payments\Events\PaymentCompleted;
use App\Modules\Payments\Events\PaymentFailed;
use App\Modules\Payments\Events\RefundCompleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class PaymentServiceEventProvider extends EventServiceProvider
{
    protected $listen = [
        PaymentCompleted::class => [
            // Listeners for PaymentCompleted event
        ],
        PaymentFailed::class => [
            // Listeners for PaymentFailed event
        ],
        RefundCompleted::class => [
            // Listeners for RefundCompleted event
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}