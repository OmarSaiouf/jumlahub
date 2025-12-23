<?php

namespace App\Modules\Invoices\Listeners;

use App\Core\Enums\InvoiceStatus;
use App\Modules\Invoices\Models\Invoice;
use App\Modules\Orders\Events\OrderCanceled;
use App\Modules\Orders\Events\OrderCreated;
use App\Modules\Payments\Events\PaymentCompleted;

class CancelInvoiceForOrder
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCanceled $event): void
    {

    }
}