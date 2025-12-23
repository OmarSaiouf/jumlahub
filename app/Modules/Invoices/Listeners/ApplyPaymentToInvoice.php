<?php

namespace App\Modules\Invoices\Listeners;

use App\Core\Enums\InvoiceStatus;
use App\Modules\Invoices\Models\Invoice;
use App\Modules\Payments\Events\PaymentCompleted;

class ApplyPaymentToInvoice
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
     * 
     */
    public function handle(PaymentCompleted $event): void
    {
        $invoice = Invoice::where('payment_id', $event->payment->id)
            ->lockForUpdate()
            ->first();
        if (!$invoice) {
            return; // No invoice found for this payment
        }
        $invoice->status = InvoiceStatus::PAID->value;
        $invoice->metadata = array_merge($invoice->metadata ?? [], [
            'paid_at' => now()->toDateTimeString(),
            'payment_reference' => $event->payment->reference,
        ]);
        // $invoice->url_pdf = generateInvoicePdf($invoice);
        $invoice->issued_at = now()->toDateString();
        $invoice->due_date = now()->addDays(30)->toDateString();

        $invoice->save();
    }
}