<?php

namespace App\Core\Http\Controllers;

use App\Core\Facades\PaymentProviderFacade;
use App\Modules\Products\Facades\ProductFacade;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(string $id)
    {
        $product = ProductFacade::find($id);

        abort_if(!$product, 404, 'Product not found.');

        $product->loadMissing(['category']);

        $availableQuantity = max(($product->quantity ?? 0) - ($product->quantity_sold ?? 0), 0);
        $progressPercent = ($product->quantity ?? 0) > 0
            ? round(min(($product->quantity_sold / $product->quantity) * 100, 100), 2)
            : 0.0;
        $isOpen = !$product->is_quantity_finished && $availableQuantity > 0;

        $userOrdersCount = 0;

        if (Auth::guard('web')->check()) {
            $userOrdersCount = $product->orders()
                ->where('user_id', Auth::guard('web')->id())
                ->count();
        }

        return view('pages.product_details', [
            'product' => $product,
            'paymentProviders' => PaymentProviderFacade::all()->get(),
            'availableQuantity' => $availableQuantity,
            'progressPercent' => $progressPercent,
            'isOpen' => $isOpen,
            'userOrdersCount' => $userOrdersCount,
        ]);
    }
}
