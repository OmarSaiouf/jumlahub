<?php

namespace App\Core\Http\Controllers;

use App\Core\Http\Requests\CreateOrderRequest;
use App\Core\Http\Requests\GetMyOrdersRequest;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Orders\Facades\OrderFacade;
use Exception;

class OrdersController extends Controller
{
    public function myOrder(GetMyOrdersRequest $getMyOrdersRequest)
    {
        $vaildated = $getMyOrdersRequest->validated();
        $orders = OrderFacade::allForUser(auth('web')->id(), null, $vaildated['limit'] ?? 30, $vaildated['offset'] ?? 0);
        return view('pages.orders', [
            'orders' => $orders,
            'languages' => Language::select('id', 'name', 'code')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code')->orderBy('name')->get(),
        ]);
    }

    public function store(CreateOrderRequest $createOrderRequest)
    {
        $validated = $createOrderRequest->validated();
        try {
            $order = OrderFacade::create([
                "user_id" => auth('web')->id(),
                "product_id" => $validated['product_id'],
                "quantity" => $validated['quantity'],
                "payment_provider_id" => $validated['payment_provider_id']
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect(route('web.payment.show', ["order_id" => $order->id]));
    }
}