<?php

namespace App\Modules\Invoices;

use App\Modules\Invoices\Listeners\ApplyPaymentToInvoice;
use App\Modules\Invoices\Listeners\CreateInvoiceForOrder;
use App\Modules\Orders\Events\OrderCreated;
use App\Modules\Payments\Events\PaymentCompleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class InvoiceEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateInvoiceForOrder::class,
        ],
        PaymentCompleted::class => [
            ApplyPaymentToInvoice::class,
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
