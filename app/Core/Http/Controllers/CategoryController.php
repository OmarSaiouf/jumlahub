<?php

namespace App\Core\Http\Controllers;

use App\Core\Facades\PaymentProviderFacade;
use App\Core\Http\Controllers\Controller;
use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Products\Facades\CategoryFacade;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = CategoryFacade::getByIdWithProducts($id);
        $products = $category?->products;

        // dd($category);
        return view('pages.category_details', [
            'category' => $category,
            'products' => $products,
            'languages' => Language::select('id', 'name', 'code')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code')->orderBy('name')->get(),
            "paymentProviders" => PaymentProviderFacade::all()
        ]);
    }
}