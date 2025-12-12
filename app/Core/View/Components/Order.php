<?php

namespace App\View\Components;

use App\Modules\Orders\Models\Order as ModelsOrder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Order extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ModelsOrder $order)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order');
    }
}
