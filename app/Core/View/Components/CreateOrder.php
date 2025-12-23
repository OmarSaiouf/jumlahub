<?php

namespace App\Core\View\Components;

use App\Core\Models\PaymentProvider;
use App\Modules\Products\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateOrder extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Product $product, public PaymentProvider $paymentProviders)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.create-order');
    }
}
