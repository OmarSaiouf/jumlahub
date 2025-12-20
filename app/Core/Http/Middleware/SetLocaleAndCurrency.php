<?php

namespace App\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleAndCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie('language', 'ar');
        app()->setLocale($locale);

        $currency = $request->cookie('currency', 'SYP');
        app()->instance('currency', $currency);

        $country = $request->cookie('country', '1');
        app()->instance('country', $country);

        $city = $request->cookie('city', '1');
        app()->instance('city', $city);
        Log::info("Locale set to: $locale, Currency set to: $currency, Country set to: $country, City set to: $city");
        
        return $next($request);
    }
}
