<?php

namespace App\Modules\Invoices;

use App\Core\Http\Requests\CancelOrderRequest;
use App\Modules\Invoices\Listeners\ApplyPaymentToInvoice;
use App\Modules\Invoices\Listeners\CancelInvoiceForOrder;
use App\Modules\Invoices\Listeners\CreateInvoiceForOrder;
use App\Modules\Orders\Events\OrderCanceled;
use App\Modules\Orders\Events\OrderCreated;
use App\Modules\Payments\Events\PaymentCompleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class InvoiceEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateInvoiceForOrder::class,
        ],
        OrderCanceled::class => [
            CancelInvoiceForOrder::class
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
