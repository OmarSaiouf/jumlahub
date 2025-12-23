<?php

namespace App\Core\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class PreferenceController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'language' => 'nullable|exists:languages,code',
            'currency' => 'nullable|exists:currencies,code',
            'country' => 'nullable|exists:countries,id',
            'city' => 'nullable|exists:cities,id',
        ]);

        if ($request->filled('language')) {
            if (backpack_auth()->check()) {
                backpack_user()->update(['locale' => $request->language]);
            }
            Cookie::queue('language', $request->language, 60 * 24 * 30);
        }

        if ($request->filled('currency')) {
            Cookie::queue('currency', $request->currency, 60 * 24 * 30);
        }
        if ($request->filled('country')) {
            Cookie::queue('country', $request->country, 60 * 24 * 30);
        }
        if ($request->filled('city')) {
            Cookie::queue('city', $request->city, 60 * 24 * 30);
        }
        // Log::info("Preferences updated: Language - {$request->language}, Currency - {$request->currency}, Country - {$request->country}, City - {$request->city}");
        return back();
    }
}