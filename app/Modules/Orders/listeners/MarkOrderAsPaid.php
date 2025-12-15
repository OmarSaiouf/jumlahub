<?php

namespace App\Modules\Orders\listeners;

use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Events\PaymentCompleted;

class MarkOrderAsPaid
{
    public function handle(PaymentCompleted $event)
    {
        $order = Order::find($event->payment->order_id);

        $order->product()->increment('quantity_sold', $order->quantity);
    }
}