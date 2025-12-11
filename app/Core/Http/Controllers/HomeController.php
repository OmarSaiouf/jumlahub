<?php

namespace App\Core\Http\Controllers;

use App\Modules\Products\Facades\CategoryFacade;
use App\Modules\Products\Facades\ProductFacade;

class HomeController extends Controller
{
    public function index()
    {
        $categories = CategoryFacade::all()->get();
        // dd();
        $products = ProductFacade::all()->get();

        return view('index', [
            'categories' => $categories,
            "products" => $products
        ]);
    }
}