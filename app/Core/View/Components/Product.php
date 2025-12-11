<?php

namespace App\Core\View\Components;

use App\Modules\Products\Models\Product as ModelsProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Product extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ModelsProduct $product)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product');
    }
}
