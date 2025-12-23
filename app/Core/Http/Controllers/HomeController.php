<?php

namespace App\Core\Http\Controllers;

use App\Core\Enums\FilterSort;
use App\Core\Enums\FilterStatus;
use App\Core\Facades\PaymentProviderFacade;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Core\Http\Requests\FilterRequest;
use App\Modules\Products\Facades\CategoryFacade;
use App\Modules\Products\Facades\ProductFacade;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(FilterRequest $request)
    {
        $request = $request->validated();

        $filters = [
            "language_id" => Language::where('code', app()->getLocale())->first()->id,
            "sort" => $request['sort'] ?? null,
            "status" => $request['status'] ?? null,
            "q" => $request['q'] ?? null,
        ];

        $categories = CategoryFacade::all(filters: $filters, limit: 12)->orderBy('created_at', 'asc')
            ->get();
        // ->map(function ($category) {
        //     $category->image = $category->image ? Storage::disk('public')->url($category->image) : null;
        //     return $category;
        // });

        $products = ProductFacade::all(filters: $filters)->orderBy('created_at', 'asc')
            ->get();
        // ->map(function ($product) {
        //     $product->image = $product->image ? Storage::disk('public')->url($product->image) : null;
        //     return $product;
        // });


        return view('index', [
            'categories' => $categories,
            "products" => $products,
            'languages' => Language::select('id', 'name', 'code')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code')->orderBy('name')->get(),
            "paymentProviders" => PaymentProviderFacade::all(),
            'filterSorts' => FilterSort::getAllKeyValues(),
            'filterStatuses' => FilterStatus::getAllKeyValues(),
        ]);
    }
}