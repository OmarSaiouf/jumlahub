<?php

namespace App\Core\Http\Controllers;

use App\Core\Http\Requests\PayRequest;
use App\Core\Http\Requests\ShowPaymentRequest;
use App\Modules\Orders\Facades\OrderFacade;
use App\Modules\Orders\Models\Order;
use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payments\Enums\PaymentStatusEnum;
use App\Modules\Payments\Facades\PaymentFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function show(ShowPaymentRequest $showPaymentRequest)
    {
        $validated = $showPaymentRequest->validated();

        $order = OrderFacade::find($validated['order_id']);
        return view("pages.payment", [
            'order' => $order
        ]);
    }


    public function pay(PayRequest $payRequest)
    {
        $validated = $payRequest->validated();

        $order = OrderFacade::find($validated['order_id']);

        if (!$order || !$order->exists()) {
            return back()->with('error', 'order yok');
        }

        $total = $order->quantity * $order->product->price;

        try {
            DB::beginTransaction();

            $paymentData = new PaymentData(
                amount: $total,
                currency: $order->product->currency->code,
                referenceId: "R-{$order->id}-" . uniqid(),
                description: "Order id: {$order->id}",
                meta: [
                    'providerId' => $order->paymentProvider->id,
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ]
            );

            $result = PaymentFacade::pay(
                $order->paymentProvider->code,
                $paymentData
            );

            if ($result->status === PaymentStatusEnum::FAILED) {
                DB::rollBack();
                return back()->with('error', 'Payment failed');
            }

            DB::commit();

            return redirect()->to($result->data['redirect_url']);

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        if (PaymentFacade::processWebhook($request)) {
            // OrderFacade::find();
        }

        return response()->json(['ok' => true]);
    }
}
