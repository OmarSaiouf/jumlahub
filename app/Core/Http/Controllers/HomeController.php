<?php

namespace App\Core\Http\Controllers;

use App\Core\Facades\PaymentProviderFacade;
use App\Modules\Products\Facades\CategoryFacade;
use App\Modules\Products\Facades\ProductFacade;

class HomeController extends Controller
{
    public function index()
    {
        $categories = CategoryFacade::all();
        $products = ProductFacade::all();
        
        return view('index', [
            'categories' => $categories,
            "products" => $products,
            "paymentProviders" => PaymentProviderFacade::all()
        ]);
    }
}