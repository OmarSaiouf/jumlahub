<?php

namespace App\Core\Http\Controllers;

use App\Core\Facades\PaymentProviderFacade;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Products\Facades\CategoryFacade;
use App\Modules\Products\Facades\ProductFacade;

class HomeController extends Controller
{
    public function index()
    {

        $filters = [
            "currency_id" => Currency::where('code', app('currency'))->first()?->id,
            "language_id" => Language::getFromCode(app()->getLocale())?->id,
            "city_id" => auth('web')->user()->city_id ?? "",
            "country_id" => auth('web')->user()->country_id ?? "",
            // ""
        ];
        // dd($filters);
        $categories = CategoryFacade::all(filters: $filters, limit: 12)->orderBy('name', 'asc')->get();
        $products = ProductFacade::all(filters: $filters)->orderBy('created_at', 'asc')->get();

        return view('index', [
            'categories' => $categories,
            "products" => $products,
            'languages' => Language::select('id', 'name', 'code')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code')->orderBy('name')->get(),
            "paymentProviders" => PaymentProviderFacade::all()
        ]);
    }
}