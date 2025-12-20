<?php

namespace App\Modules\Invoices\Listeners;

use App\Core\Enums\InvoiceStatus;
use App\Modules\Invoices\Models\Invoice;
use App\Modules\Orders\Events\OrderCreated;
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
    public function handle(OrderCreated $event): void
    {
        Invoice::create([
            'user_id' => $event->order->user_id,
            // 'payment_id' => $event->order->payment_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'amount' => $event->order->amount,
            'currency_id' => $event->order->load('product')->product->currency_id,
            'status' => InvoiceStatus::PENDING->value,
        ]);
    }
}