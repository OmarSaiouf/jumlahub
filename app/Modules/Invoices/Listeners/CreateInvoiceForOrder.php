<?php

namespace App\Modules\Invoices\Listeners;

use App\Core\Enums\InvoiceStatus;
use App\Modules\Invoices\Models\Invoice;
use App\Modules\Payments\Events\PaymentCompleted;

class CreateInvoiceForOrder
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
    public function handle(PaymentCompleted $event): void
    {
        Invoice::create([
            'user_id' => $event->payment->user_id,
            'payment_id' => $event->payment->id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'amount' => $event->payment->amount,
            'currency_id' => $event->payment->currency_id,
            'status' => InvoiceStatus::PENDING->value,
        ]);
    }
}